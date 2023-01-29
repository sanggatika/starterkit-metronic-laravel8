<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use mainHelpers;
use Carbon\Carbon;

// Database
use Illuminate\Support\Facades\DB;
use App\Models\Menu;

class ManagementMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexManagementMenu(Request $request){
        $model['route'] = 'Management Menu';
        $model['MsMenu'] = Menu::orderBy('menu_grup_sort', 'asc')->get();
        // dd($model['MsMenu']);
        return view('pages.management-menu.v_index', ['model' => $model]);
    }

    public function act_tambahManagementMenu(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        $userAgent = mainHelpers::getUserAgent();
        // wajib menggunakan request ajax
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'form_menu_grup' => 'required',
                'form_menu_nama' => 'required',
                'form_menu_uri' => 'required',
                'form_menu_routename' => 'required',
                'recaptcha' => 'required|captcha'
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Menu Dalam Database
            $checkExistingDataMenu =  Menu::where('menu_url', $request->form_menu_uri)->first();            
            
            $menu_icon = '<i class="bi bi-columns-gap text-white me-5"></i>';
            if($request->form_menu_icon != "")
            {
                $menu_icon = '<i class="bi '.$request->form_menu_icon.' text-white me-5"></i>';
            }

            // pengecekan parent
            $checkMenuParent = null;
            $menu_parent = 0;
            if($request->form_menu_parent != '-')
            {
                $checkMenuParent = Menu::where('menu_uuid', $request->form_menu_parent)->first();
                $menu_parent = $checkMenuParent->id;
                $menu_icon = null;
            }

            switch ($request->form_menu_grup) {
                case "1":
                    $menu_grup = "Menu Utama";
                    $menu_grup_sort = 1;
                    break;
                case "2":
                    $menu_grup = "Rekapitulasi";
                    $menu_grup_sort = 2;
                    break;
                case "3":
                    $menu_grup = "Master Data";
                    $menu_grup_sort = 3;
                    break;
                case "4":
                    $menu_grup = "Konfigurasi Apps";
                    $menu_grup_sort = 4;
                    break;
                default:
                    $menu_grup = "Menu Utama";
                    $menu_grup_sort = 1;
            }

            DB::beginTransaction();
            try {
                // menyimpan data transaksi kedalam database
                $AddDBTransaksi = new Menu();

                $AddDBTransaksi->menu_uuid = (string) Str::uuid();
                $AddDBTransaksi->menu_parent = $menu_parent;
                $AddDBTransaksi->menu_parent_status = 0;
                $AddDBTransaksi->menu_kode = "MN-".Str::random(6);
                $AddDBTransaksi->menu_title = $request->form_menu_nama;
                $AddDBTransaksi->menu_url = $request->form_menu_uri;
                $AddDBTransaksi->menu_routename = $request->form_menu_routename;

                $AddDBTransaksi->menu_grup = $menu_grup;
                $AddDBTransaksi->menu_grup_sort = $menu_grup_sort;

                $AddDBTransaksi->menu_icon = $menu_icon;

                $AddDBTransaksi->menu_new_tab = 0;
                $AddDBTransaksi->menu_desc = 0;
                $AddDBTransaksi->menu_sort = 999;
                $AddDBTransaksi->menu_sort_header = 0;
                $AddDBTransaksi->menu_visible = 1;
                $AddDBTransaksi->menu_status = 1;
                $AddDBTransaksi->menu_exclude = 0;
                $AddDBTransaksi->created_at = Carbon::now('Asia/Jakarta');
                $AddDBTransaksi->created_by = Auth::user()->id;

                $AddDBTransaksi->save();

                if($checkMenuParent != null)
                {
                    $checkMenuParent->menu_parent_status = 1;
                    $checkMenuParent->updated_by = Auth::user()->id;
                    $checkMenuParent->save();
                }

                DB::commit();

                $status = true;
                $response_code = 'RC200';
                $message = 'Data menu berhasil ditambahkan, terimakasih !';
                $dataAPI = null;

                return $this->onResult($status, $response_code, $message, $dataAPI);

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

    public function get_detailManagementMenu(Request $request)
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
            $checkExistingDataMenu =  Menu::where('menu_uuid', $request->data_id)->first();           
            
            if(!$checkExistingDataMenu)
            {
                $response_code = "RC401";
                $message = "Data Menu Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $parent_uuid = null;
            if($checkExistingDataMenu->menu_parent != 0)
            {
                $dataMenuParent = Menu::where('id', $checkExistingDataMenu->menu_parent)->first();
                $parent_uuid = $dataMenuParent->menu_uuid;
            }
            $checkExistingDataMenu->parent_uuid = $parent_uuid;

            $dataAPI = Str::random(3).Crypt::encryptString($checkExistingDataMenu).Str::random(6);
            $status = true;
            $response_code = "RC200";
            $message = "Anda Berhasil Load Data Detail Menu !!";

            return $this->onResult($status, $response_code, $message, $dataAPI);
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    public function act_editManagementMenu(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        $userAgent = mainHelpers::getUserAgent();
        // wajib menggunakan request ajax
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'form_menu_uuid' => 'required',
                'form_menu_grup' => 'required',
                'form_menu_nama' => 'required',
                'form_menu_uri' => 'required',
                'form_menu_routename' => 'required'
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Menu Dalam Database
            $checkExistingDataMenu =  Menu::where('menu_uuid', $request->form_menu_uuid)->first(); 
            if(!$checkExistingDataMenu)
            {
                $response_code = "RC401";
                $message = "Data Menu Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }           
            
            $menu_icon = '<i class="bi bi-columns-gap text-white me-5"></i>';
            if($request->form_menu_icon != "")
            {
                $menu_icon = '<i class="bi '.$request->form_menu_icon.' text-white me-5"></i>';
            }

            switch ($request->form_menu_grup) {
                case "1":
                    $menu_grup = "Menu Utama";
                    $menu_grup_sort = 1;
                    break;
                case "2":
                    $menu_grup = "Rekapitulasi";
                    $menu_grup_sort = 2;
                    break;
                case "3":
                    $menu_grup = "Master Data";
                    $menu_grup_sort = 3;
                    break;
                case "4":
                    $menu_grup = "Konfigurasi Apps";
                    $menu_grup_sort = 4;
                    break;
                default:
                    $menu_grup = "Menu Utama";
                    $menu_grup_sort = 1;
            }

            // pengecekan parent
            $checkMenuParent = null;
            $menu_parent = 0;
            if($request->form_menu_parent != '-')
            {
                $checkMenuParent = Menu::where('menu_uuid', $request->form_menu_parent)->first();
                $menu_parent = $checkMenuParent->id;
                $menu_icon = null;
            }

            // update menu
            if($checkExistingDataMenu->menu_parent != 0)
            {
                if($request->form_menu_parent != $checkExistingDataMenu->menu_parent)
                {
                    $getSameParent = Menu::where('menu_parent', $checkExistingDataMenu->menu_parent)->get();
                    if($getSameParent->count() == 1)
                    {
                        $MenuParent = Menu::where('id', $checkExistingDataMenu->menu_parent)->first();

                        $MenuParent->menu_parent_status = 0;
                        $MenuParent->save();
                    }
                }
            }
            

            DB::beginTransaction();
            try {
                // menyimpan data transaksi kedalam database
                $checkExistingDataMenu->menu_parent = $menu_parent;
                $checkExistingDataMenu->menu_title = $request->form_menu_nama;
                $checkExistingDataMenu->menu_url = $request->form_menu_uri;
                $checkExistingDataMenu->menu_routename = $request->form_menu_routename;

                $checkExistingDataMenu->menu_grup = $menu_grup;
                $checkExistingDataMenu->menu_grup_sort = $menu_grup_sort;

                $checkExistingDataMenu->menu_icon = $menu_icon;

                $checkExistingDataMenu->menu_sort = 999;
                $checkExistingDataMenu->updated_at = Carbon::now('Asia/Jakarta');
                $checkExistingDataMenu->updated_by = Auth::user()->id;                

                if($checkMenuParent != null)
                {
                    $checkExistingDataMenu->menu_grup = $checkMenuParent->menu_grup;
                    $checkExistingDataMenu->menu_grup_sort = $checkMenuParent->menu_grup_sort;

                    $checkMenuParent->menu_parent_status = 1;
                    $checkMenuParent->updated_by = Auth::user()->id;
                    $checkMenuParent->save();
                }

                $checkExistingDataMenu->save();

                DB::commit();

                $status = true;
                $response_code = 'RC200';
                $message = 'Data menu berhasil diupdate, terimakasih !';
                $dataAPI = null;

                return $this->onResult($status, $response_code, $message, $dataAPI);

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

    public function act_editstatusManagementMenu(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        $userAgent = mainHelpers::getUserAgent();
        // wajib menggunakan request ajax
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'data_menu' => 'required',
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
            $checkExistingDataMenu =  Menu::where('menu_uuid', $request->data_menu)->first(); 
            if(!$checkExistingDataMenu)
            {
                $response_code = "RC401";
                $message = "Data Menu Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
            
            $menu_status = 0;
            $menu_visible = 0;

            if($request->data_status == 0)
            {
                $menu_status = 1;
                $menu_visible = 1;
            }

            $checkExistingDataMenu->menu_visible = $menu_visible;
            $checkExistingDataMenu->menu_status = $menu_status;
            $checkExistingDataMenu->updated_at = Carbon::now('Asia/Jakarta');
            $checkExistingDataMenu->updated_by = Auth::user()->id; 

            $checkExistingDataMenu->save();

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

    public function act_sortManagementMenu(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        $userAgent = mainHelpers::getUserAgent();
        // wajib menggunakan request ajax
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'data_menu' => 'required',
                'data_sort' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Menu Dalam Database
            $checkExistingDataMenu =  Menu::where('menu_uuid', $request->data_menu)->first(); 
            if(!$checkExistingDataMenu)
            {
                $response_code = "RC401";
                $message = "Data Menu Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
            
            $data_sort = 0;

            if($checkExistingDataMenu->menu_parent == 0)
            {
                $getMenu = Menu::where('menu_grup', $checkExistingDataMenu->menu_grup)->where('menu_parent', 0)->orderBy('menu_sort', 'ASC')->get();

                $sort = 1;
                foreach($getMenu as $menu)
                {
                    $menu->menu_sort = $sort;
                    $menu->updated_at = Carbon::now('Asia/Jakarta');
                    $menu->updated_by = Auth::user()->id; 
                    $menu->save();

                    $sort++;
                }

                $changeMenu =  Menu::where('menu_uuid', $request->data_menu)->first();
                if($request->data_sort == 'up')
                {
                    $rollMenu = Menu::where('menu_grup', $checkExistingDataMenu->menu_grup)->where('menu_parent', 0)->where('menu_sort', $changeMenu->menu_sort - 1)->first();
                    
                    $changeMenu->menu_sort = $changeMenu->menu_sort - 1;
                    $rollMenu->menu_sort = $rollMenu->menu_sort + 1;
                }

                if($request->data_sort == 'down')
                {
                    $rollMenu = Menu::where('menu_grup', $checkExistingDataMenu->menu_grup)->where('menu_parent', 0)->where('menu_sort', $changeMenu->menu_sort + 1)->first();
                    
                    $changeMenu->menu_sort = $changeMenu->menu_sort + 1;
                    $rollMenu->menu_sort = $rollMenu->menu_sort - 1;
                }

                $changeMenu->save();
                $rollMenu->save();
            }else{
                $getMenu = Menu::where('menu_parent', $checkExistingDataMenu->menu_parent)->orderBy('menu_sort', 'ASC')->get();
                
                $sort = 1;
                foreach($getMenu as $menu)
                {
                    $menu->menu_sort = $sort;
                    $menu->updated_at = Carbon::now('Asia/Jakarta');
                    $menu->updated_by = Auth::user()->id; 
                    $menu->save();

                    $sort++;
                }

                $changeMenu =  Menu::where('menu_uuid', $request->data_menu)->first();
                if($request->data_sort == 'up')
                {
                    $rollMenu = Menu::where('menu_parent', $checkExistingDataMenu->menu_parent)->where('menu_sort', $changeMenu->menu_sort - 1)->first();
                    
                    $changeMenu->menu_sort = $changeMenu->menu_sort - 1;
                    $rollMenu->menu_sort = $rollMenu->menu_sort + 1;
                }

                if($request->data_sort == 'down')
                {
                    $rollMenu = Menu::where('menu_parent', $checkExistingDataMenu->menu_parent)->where('menu_sort', $changeMenu->menu_sort + 1)->first();
                    
                    $changeMenu->menu_sort = $changeMenu->menu_sort + 1;
                    $rollMenu->menu_sort = $rollMenu->menu_sort - 1;
                }

                $changeMenu->save();
                $rollMenu->save();
            }

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
