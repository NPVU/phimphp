<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;

class ServicesController extends Controller
{    
    public function callWebService($method, $url, $data = false){
        $curl = curl_init();
        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);        
        return $result;
    }
    public function openloadTicketAPI($fileID, $loginKey, $apiKey){
        $url = "https://api.openload.co/1/file/dlticket?file=$fileID&login=$loginKey&key=$apiKey";
        return $this->callWebService("GET", $url, false);
    }
    public function openloadDownloadAPI($fileID, $ticket, $captcha){
        $url = "https://api.openload.co/1/file/dl?file=$fileID&ticket=$ticket&captcha_response=$captcha";
        return $this->callWebService("GET", $url, false);
    }
       
}
