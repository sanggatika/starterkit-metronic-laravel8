<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_homeLanding(Request $request){
        // dd(Carbon::now()->format('Y'));
        $model['route'] = 'Home';
        return view('pages.publik.beranda.v_beranda', ['model' => $model]);
    }
}
