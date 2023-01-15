<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Session;

//Conect to DB
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
  //Login page
  public function page_loginAuthentication(){
    if(Auth::check())
    {
      return redirect('/');
    }else{
      $model['route'] = 'Auth';
      return view('pages.auth.signin', ['model' => $model]);
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
