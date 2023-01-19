<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use mainHelpers;
use Carbon\Carbon;

//Conect to DB
use Illuminate\Support\Facades\DB;
use App\Models\LogLogin;
use App\Models\User;
use App\Models\PasswordReset;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_forgotAuthentication()
    {        
        if(Auth::check())
        {
            return redirect('/');
        }else {
            $model['route'] = 'Forgot';
            return view('pages.auth.forgot', ['model' => $model]);
        }
    }

    public function act_forgotAuthentication(Request $request)
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
                'recaptcha' => 'required|captcha'
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data User Dalam Database
            $checkExistingDataUser =  User::where('email', $request->username)->first();

            if(!$checkExistingDataUser)
            {
                $response_code = "RC400";
                $message = "Email atau Username Tidak Terdaftar Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Reset Password
            $checkResetPassword =  PasswordReset::where('email', $request->username)->where('status', 0)->orderBy('created_at', 'desc')->first();
            
            if ($checkResetPassword) {
                $start = Carbon::parse($checkResetPassword->created_at);
                $end = Carbon::now('Asia/Jakarta');
                $selisih = $start->diffInMinutes($end);

                $limit = (int) env("MAX_TOKEN_EMAIL_RESEND", 5);
    
                if ($limit > $selisih) {
                    $message = "Tidak dapat mengirim email, silahkan tunggu " . ($limit - $selisih) . " menit untuk meminta email baru. Atau cek email anda pada kotak masuk dan spam untuk melanjutkan proses reset password.";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }
            }

            $email = $checkExistingDataUser->email;

            $token = Str::random(64);

            DB::beginTransaction();
            try {
                // menyimpan data transaksi kedalam database
                $AddDBTransaksi = new PasswordReset();

                $AddDBTransaksi->uuid = (string) Str::uuid();
                $AddDBTransaksi->email = $email;
                $AddDBTransaksi->token = $token;
                $AddDBTransaksi->status = 0;
                $AddDBTransaksi->created_at = Carbon::now('Asia/Jakarta');

                $AddDBTransaksi->save();

                // proses kirim email
                $sendEmailData = [
                    // 'to' => $antrian[$i]->antrian_email,
                    'to' => 'sanggatika@gmail.com',
                    'subject' => "Konfirmasi Reset Password",
                    'html' => view('pages.email.auth_resetpassword', [
                        'link' => url('auth/reset') . "/" . $token
                    ])->render(),
                ];
                
                $process_email  = mainHelpers::sendEmail($sendEmailData);

                if ($process_email['state'] == true) 
                {
                    DB::commit();

                    $status = true;
                    $response_code = 'RC200';
                    $message = 'Konfirmasi reset password berhasil dikirim ke email..';
                    $dataAPI = null;

                    return $this->onResult($status, $response_code, $message, $dataAPI);
                } else {
                    DB::rollback();                    

                    if(isset($process_email['message']))
                    {
                        Log::critical($process_email['message']);
                    }

                    if(isset($process_email['error']))
                    {
                        Log::critical($process_email['error']);
                    }

                    $response_code = "RC400";
                    $message = "Sistem gagal Kesalahan saat kirim email konfirmasi !!";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }                               
            } catch (\Throwable $error) {
                DB::rollback();
                Log::critical($error);
                
                $response_code = "RC400";
                $message = "Sistem gagal proses data, Kesalahan saat kirim data !!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_resetAuthentication($token)
    {        
        if(Auth::check())
        {
            return redirect('/');
        }else {
            if(!$token)
            {
                return redirect('/auth/login');
            }

            $is_valid = [
                'status' => true,
                'reason' => 'token_valid'
            ];
    
            // Cek Token
            $checkToken =  PasswordReset::where('token', $token)->first();
            // dd($checkToken);

            $model['token'] = null;
            
            // validasi token
            if(!$checkToken)
            {
                $is_valid['status'] = false;
                $is_valid['reason'] = 'token_invalid';
            }else{
                if($checkToken->status == 1)
                {
                    $is_valid['status'] = false;
                    $is_valid['reason'] = 'token_sudah_digunakan';
                }

                if($checkToken->status == -1)
                {
                    $is_valid['status'] = false;
                    $is_valid['reason'] = 'token_expired';
                }else{
                    if ((Carbon::parse($checkToken->created_at)->addMinutes(env("MAX_TOKEN_EMAIL_EXPIRED", 15)) >= Carbon::now('Asia/Jakarta')) == false) {
                        $is_valid['status'] = false;
                        $is_valid['reason'] = 'token_expired';
    
                        $checkToken->status = '-1';
                        $checkToken->save();
                    } 
                }

                $model['token'] = $checkToken->token;
            };

            $model['route'] = 'Reset';
            $model['vilid_token'] = $is_valid;
            return view('pages.auth.reset', ['model' => $model]);
        }
    }

    public function act_resetAuthentication(Request $request)
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
                'token' => 'required',
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

            // validasi controller check password
            if(mainHelpers::checkStrengthPassword($request->password) == false)
            {
                $response_code = "RC401";
                $message = "Password Belum Memenuhi Standar Keamanan";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Token
            $checkToken =  PasswordReset::where('token', $request->token)->first();

            if(!$checkToken)
            {
                $response_code = "RC400";
                $message = "Data token invalid";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            if($checkToken->status == 1)
            {
                $response_code = "RC400";
                $message = "Token sudah digunakan";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            if($checkToken->status == -1)
            {
                $response_code = "RC400";
                $message = "Token sudah expired";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }else{
                if ((Carbon::parse($checkToken->created_at)->addMinutes(env("MAX_TOKEN_EMAIL_EXPIRED", 15)) >= Carbon::now('Asia/Jakarta')) == false) 
                {
                    $response_code = "RC400";
                    $message = "Token sudah expired";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                } 
            }

            // Cek Data User Dalam Database
            $checkExistingDataUser =  User::where('email', $checkToken->email)->first();

            if(!$checkExistingDataUser)
            {
                $response_code = "RC400";
                $message = "Email atau Username Tidak Terdaftar Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // proses update
            DB::beginTransaction();
            try {
                $checkToken->status = '1';
                $checkToken->save();

                $checkExistingDataUser->password = Hash::make($request->password);
                $checkExistingDataUser->updated_at = Carbon::now('Asia/Jakarta');

                $checkExistingDataUser->save();

                DB::commit();
                
                $status = true;
                $response_code = "RC200";
                $message = "Anda Berhasil Update Password, silahkan login !!";
                $dataAPI = null;
        
                return $this->onResult($status, $response_code, $message, $dataAPI);
            } catch (\Throwable $error) {
                DB::rollback();
                Log::critical($error);
        
                $response_code = "RC400";
                $message = "Gagal Update Data Kedalam Sistem !!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
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
