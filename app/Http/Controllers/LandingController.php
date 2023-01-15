<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_homeLanding(Request $request){
        $model['route'] = 'Home';
        return view('pages.publik.beranda.v_beranda', ['model' => $model]);
    }
}
