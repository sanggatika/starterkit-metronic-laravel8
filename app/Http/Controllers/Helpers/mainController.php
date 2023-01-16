<?php

namespace App\Http\Controllers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Agent;

class mainController extends Controller
{
    // Get Client Data
    public static function getUserAgent()
    {   
        return [
            'browser' => Agent::browser(),
            'version' => Agent::version(Agent::browser()),
            'platform' => Agent::platform(),
            'mobiles' => Agent::device(),

        ];
    }

    public static function get_client_ip($request)
    {   
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = $request;
        return $ipaddress;
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