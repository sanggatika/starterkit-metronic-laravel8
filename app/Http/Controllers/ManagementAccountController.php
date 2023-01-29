<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use mainHelpers;
use Carbon\Carbon;
use Redirect;

// Database
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ManagementAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexManagementAccount(Request $request){
        $model['route'] = 'Management Role';
        return view('pages.management-account.v_index', ['model' => $model]);
    }

    public function act_editManagementAccount(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        $userAgent = mainHelpers::getUserAgent();
        // wajib menggunakan request ajax
        if ($request->ajax()) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'form_account_uuid' => 'required',
                'form_account_name' => 'required',
                'form_account_handphone' => 'required',
                'form_account_jabatan' => 'required',
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
            $checkExistingDatUser =  User::where('uuid', $request->form_account_uuid)->first(); 
            if(!$checkExistingDatUser)
            {
                $response_code = "RC401";
                $message = "Data User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $checkExistingDatUser->nama = $request->form_account_name;
            $checkExistingDatUser->telepon = $request->form_account_handphone;
            $checkExistingDatUser->jabatan = $request->form_account_jabatan;
            $checkExistingDatUser->updated_by = Auth::user()->id;
            $checkExistingDatUser->updated_at = Carbon::now('Asia/Jakarta');
            $checkExistingDatUser->save();

            $status = true;
            $response_code = 'RC200';
            $message = 'Data menu berhasil diupdate, terimakasih !';
            $dataAPI = null;

            return $this->onResult($status, $response_code, $message, $dataAPI);
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    public function act_editpassManagementAccount(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        $userAgent = mainHelpers::getUserAgent();
        // wajib menggunakan request ajax
        if ($request->ajax()) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'form_account_uuid' => 'required',
                'form_account_pass_curent' => 'required',
                'form_account_pass' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // validasi controller check password
            if(mainHelpers::checkStrengthPassword($request->form_account_pass) == false)
            {
                $response_code = "RC401";
                $message = "Password Belum Memenuhi Standar Keamanan";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data User Dalam Database
            $checkExistingDataUser =  User::where('uuid', $request->form_account_uuid)->first(); 
            if(!$checkExistingDataUser)
            {
                $response_code = "RC401";
                $message = "Data User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // check auth user
            // dd(Hash::make($request->password));
            // $user = User::where('username', $request->username)->first();
            // dd(Hash::check($request->form_account_pass_curent, $checkExistingDatUser->password));

            if(Hash::check($request->form_account_pass_curent, $checkExistingDataUser->password) == false)
            {
                $response_code = "RC401";
                $message = "Data Password Saat Ini Tidak Sesuai !!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            if($request->form_account_pass_curent == $request->form_account_pass)
            {
                $response_code = "RC401";
                $message = "Data Password Baru Tidak Boleh Sama dengan Password Sebelumnya";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $params = [
                'password' => Hash::make($request->form_account_pass),
                'updated_at' => Carbon::now('Asia/Jakarta')
            ];

            // proses update
            try {
                // update user
                User::where('id', $checkExistingDataUser->id)
                ->update($params);

                $status = true;
                $response_code = "RC200";
                $message = "Anda Berhasil Update Password !!";
                $dataAPI = null;
        
                return $this->onResult($status, $response_code, $message, $dataAPI);
            } catch (\Throwable $error) {
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

    private static function onResult($status, $response_code, $message, $data)
    {
        $model['status'] = $status;
        $model['response_code'] = $response_code;
        $model['message'] = $message;
        $model['data'] = $data;
        return response()->json($model, 200);
    }
}
