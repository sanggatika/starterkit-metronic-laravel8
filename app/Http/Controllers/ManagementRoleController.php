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

// Database
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class ManagementRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexManagementRole(Request $request){
        $model['route'] = 'Management Role';
        $model['msrole'] = Role::get();
        return view('pages.management-role.v_index', ['model' => $model]);
    }
    
    public function act_tambahManagementRole(Request $request)
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
                'form_role_nama' => 'required',
                'recaptcha' => 'required|captcha'
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $form_role_nama = strtoupper($request->form_role_nama);
            // Cek Data Menu Dalam Database
            $checkExistingDataRole =  Role::where('name', $form_role_nama)->first();
            
            if($checkExistingDataRole)
            {
                $response_code = "RC401";
                $message = "Data Role User Sudah Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $form_role_deskripsi = $form_role_nama;
            if($request->form_role_deskripsi != null)
            {
                $form_role_deskripsi = $request->form_role_deskripsi;
            }

            DB::beginTransaction();
            try {
                // menyimpan data transaksi kedalam database
                $AddDBTransaksi = new Role();

                $AddDBTransaksi->uuid = (string) Str::uuid();
                $AddDBTransaksi->name = $form_role_nama;
                $AddDBTransaksi->description = $form_role_deskripsi;
                $AddDBTransaksi->status = 1;
                $AddDBTransaksi->created_at = Carbon::now('Asia/Jakarta');

                $AddDBTransaksi->save();

                DB::commit();

                $status = true;
                $response_code = 'RC200';
                $message = 'Data role berhasil ditambahkan, terimakasih !';
                $dataAPI = null;

                return $this->onResult($status, $response_code, $message, $dataAPI);

            } catch (\Throwable $error) {
                DB::rollback();
                Log::critical($error);
                
                $response_code = "RC400";
                $message = "Sistem gagal proses data, Kesalahan saat simpan data !!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    public function get_detailManagementRole(Request $request)
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
                'data_id' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Menu Dalam Database
            $checkExistingDataRole =  Role::where('uuid', $request->data_id)->first();
            
            if(!$checkExistingDataRole)
            {
                $response_code = "RC401";
                $message = "Data Role User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $dataAPI = $checkExistingDataRole;
            $status = true;
            $response_code = "RC200";
            $message = "Anda Berhasil Load Data Detail Role User !!";

            return $this->onResult($status, $response_code, $message, $dataAPI);
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    public function act_editManagementRole(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        $userAgent = mainHelpers::getUserAgent();
        // wajib menggunakan request ajax
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'form_role_uuid' => 'required',
                'form_role_nama' => 'required',
                'form_role_deskripsi' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Menu Dalam Database
            $checkExistingDataRole =  Role::where('uuid', $request->form_role_uuid)->first(); 
            if(!$checkExistingDataRole)
            {
                $response_code = "RC401";
                $message = "Data Role User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $checkExistingDataRole->name = $request->form_role_nama;
            $checkExistingDataRole->description = $request->form_role_deskripsi;

            $checkExistingDataRole->save();

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

    public function act_editstatusManagementRole(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        $userAgent = mainHelpers::getUserAgent();
        // wajib menggunakan request ajax
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'data_id' => 'required',
                'data_status' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Menu Dalam Database
            $checkExistingDataRole =  Role::where('uuid', $request->data_id)->first(); 
            if(!$checkExistingDataRole)
            {
                $response_code = "RC401";
                $message = "Data Role User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
            
            $role_status = 0;

            if($request->data_status == "aktivasi")
            {
                $role_status = 1;
            }

            $checkExistingDataRole->status = $role_status;
            $checkExistingDataRole->save();

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

    private static function onResult($status, $response_code, $message, $data)
    {
        $model['status'] = $status;
        $model['response_code'] = $response_code;
        $model['message'] = $message;
        $model['data'] = $data;
        return response()->json($model, 200);
    }
}
