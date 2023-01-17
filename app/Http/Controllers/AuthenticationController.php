<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use mainHelpers;
use Carbon\Carbon;

//Conect to DB
use Illuminate\Support\Facades\DB;
use App\Models\LogLogin;
use App\Models\User;

class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_loginAuthentication()
    {        
        if(Auth::check())
        {
            return redirect('/');
        }else {
            $model['route'] = 'Auth';
            return view('pages.auth.signin', ['model' => $model]);
        }
    }

    public function act_loginAuthentication(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        $userAgent = mainHelpers::getUserAgent();

        // wajib menggunakan request ajax
        if ($request->ajax()) {
            sleep(2);
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
                'recaptcha' => 'required|captcha'
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // set kebutuhan parameter
            $credentials = $request->only('username', 'password');
            $ipAddress = $request->ip();
            $interval = Carbon::now('Asia/Jakarta')->subMinutes(15)->toDateTimeString();
            $username = null;
            if($request->has('username'))
            {
                $username = $request->username;
            }

            // check log login
            // $whereLoginFirst = LogLogin::where(['ip_address' => $ipAddress, 'username' => $request->username, 'status' => 0])->where('created_at', '>=', $interval);
            $whereLoginFirst = LogLogin::where('status', '0')
            ->where(function ($query) use ($ipAddress, $username) {
                $query->where('ip_address', $ipAddress);
                $query->orWhere('username', $username);
            })
            ->where('browser', $userAgent['browser'])
            ->where('browser_version', $userAgent['version'])
            ->where('created_at', '>=', $interval);

            $maxLoginAttempt = env("MAX_LOGIN_ATTEMPT", 5);
            if ($whereLoginFirst->count() >= $maxLoginAttempt) {
                $lastAttempLogin = Carbon::parse($whereLoginFirst->latest()->first()->created_at);
                $lastAttempLoginAfterInterval = $lastAttempLogin->addMinutes(15);
                $different = Carbon::now('Asia/Jakarta')->diff($lastAttempLoginAfterInterval)->format('%i');
                
                $message = "Maaf, anda harus menunggu selama {$different} menit untuk bisa login kembali.";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
            
            // username dan password tidak sesuai
            if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) :
                $dataLog = [
                    'username'  => $request->username,
                    'keterangan'    => "Mencoba untuk login",
                    'ip_address'    => $ipAddress,
                    'browser'       => $userAgent['browser'],
                    'browser_version' => $userAgent['version'],
                    'platform'      => $userAgent['platform'],
                    'mobiles'       => $userAgent['mobiles'],
                    'status'    => 0,
                    'created_at'    => Carbon::now('Asia/Jakarta')
                ];
                LogLogin::insert($dataLog);

                $message = "<b>Kombinasi Username dan Password anda salah. </b><br>Anda memiliki " . ($maxLoginAttempt - $whereLoginFirst->count()) . " kali kesempatan lagi untuk mencoba masuk ke sistem.";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            endif;

            // user status aktif
            if (Auth::user()->status == 0) :
                $dataLog = [
                    'username'  => $request->username,
                    'keterangan'    => "Mencoba untuk login",
                    'ip_address'    => $ipAddress,
                    'browser'       => $userAgent['browser'],
                    'browser_version' => $userAgent['version'],
                    'platform'      => $userAgent['platform'],
                    'mobiles'       => $userAgent['mobiles'],
                    'status'    => 0,
                    'created_at'    => Carbon::now('Asia/Jakarta')
                ];
                LogLogin::insert($dataLog);
                
                Auth::logout();
                $message = "<b>User anda saat ini tidak aktif</b> <br>Anda memiliki " . ($maxLoginAttempt - $whereLoginFirst->count()) . " kali kesempatan lagi untuk mencoba masuk ke sistem.";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            endif;

            $whereLoginFirst->update(['status' => 99]);
            $dataLog = [
                'username'      => $request->username,
                'keterangan'    => "Berhasil login",
                'ip_address'    => $ipAddress,
                'browser'       => $userAgent['browser'],
                'browser_version' => $userAgent['version'],
                'platform'      => $userAgent['platform'],
                'mobiles'       => $userAgent['mobiles'],
                'status'        => 1,
                'created_at'    => Carbon::now('Asia/Jakarta')
            ];
            LogLogin::insert($dataLog);
            
            // set auth user
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
            Auth::login($user);

            // ketika langsung akses halaman tertentu
            $this->authenticated($request, $user);

            try {
                // Validate the value...
                // Get the updated rows count here. Keep in mind that zero is a
                // valid value (not failure) if there were no updates needed
                DB::table('users')->where('id', Auth::user()->id)->update([
                    'last_login' => Carbon::now('Asia/Jakarta')
                ]);
            } catch (\Throwable $error) {
                Log::critical($error);
         
                $response_code = "RC400";
                $message = "Sistem dagal login, Kesalahan update data last login !!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $status = true;
            $response_code = 'RC200';
            $message = 'Terimakasih, Anda Berhasil Masuk Aplikasi..';
            $dataAPI = null;
            
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    /**
     * Logout user
     * 
     * @return \Illuminate\Routing\Redirector
     */
    public function logoutAuthentication()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }

    private static function onResult($status, $response_code, $message, $data)
    {
        $model['status'] = $status;
        $model['response_code'] = $response_code;
        $model['message'] = $message;
        $model['data'] = $data;
        return response()->json($model, 200);
    }
}
