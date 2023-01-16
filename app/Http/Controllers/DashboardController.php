<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_admDashboard(Request $request){
        // dd(Auth::user());
        $model['route'] = 'Home';
        return view('pages.publik.beranda.v_beranda', ['model' => $model]);
    }
}
