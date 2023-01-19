<?php

namespace App\Http\Controllers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
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

    public static function sendEmail($data){
        try {
            $response = Http::withoutVerifying()->withBasicAuth(env('API_USER', 'localhost'), env('API_PASS', '1'))->post(
                env('API_URL').'/email/sender_aws',
                [
                    'to' => $data['to'],
                    'subject' => $data['subject'],
                    'html' => $data['html'],
                    'from_name' => 'Starterkit Metronic 8'
                ]
            );
            $responseData = $response->json();

            $errorMsg = [
                'RC200' => 'Sukses',
                'RC400' => 'Bad Request - Error Server',
                'RC401' => 'Unauthorized (RFC 7235) - Tidak Mempunyai Akses',
                'RC403' => 'Forbidden - URL Tidak Bisa D akses',
                'RC404' => 'Not Found - Tidak Ditemukan',
                'RC405' => 'Method Not Allowed - Format'
            ];

            if($responseData['status'] === false){
                return [
                    'state' => false,
                    'message' => $errorMsg[$responseData['response_code']],
                    'data' => $responseData
                ];
            }
            return [
                'state' => true,
                'message' => 'Sukses mengirimkan email',
                'response' => $response->json()
            ];
        } catch (\Throwable $th) {
            return [
                'state' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    public static function checkStrengthPassword($tmp_password){
        $password = $tmp_password;

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8)
        {
            return false;
        }else{
            return true;
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