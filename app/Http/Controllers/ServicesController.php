<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;

class ServicesController extends Controller
{    
    function callWebService($method, $url, $data = false){
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
    function curl($url) {
        $ch = @curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        $head[] = "Connection: keep-alive";
        $head[] = "Keep-Alive: 300";
        $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $head[] = "Accept-Language: en-us,en;q=0.5";
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $page = curl_exec($ch);
        curl_close($ch);
        return $page;
    }
    function getPhotoGoogle($link){
        $get = $this->curl($link);
        $data = explode('url\u003d', $get);
        $url = explode('%3Dm', $data[1]);
        $decode = urldecode($url[0]);
        $count = count($data);
        $linkDownload = array();
        if($count > 4) {
            $v1080p = $decode.'=m37';
            $v720p = $decode.'=m22';
            $v360p = $decode.'=m18';
            $linkDownload['1080p'] = $v1080p;
            $linkDownload['720p'] = $v720p;
            $linkDownload['360p'] = $v360p;
        }
        if($count > 3) {
            $v720p = $decode.'=m22';
            $v360p = $decode.'=m18';
            $linkDownload['720p'] = $v720p;
            $linkDownload['360p'] = $v360p;
        }
        if($count > 2) {
            $v360p = $decode.'=m18';
            $linkDownload['360p'] = $v360p;
        }
        return $linkDownload;
    }
    public function openloadTicketAPI($fileID, $loginKey, $apiKey){
        $url = "https://api.openload.co/1/file/dlticket?file=$fileID&login=$loginKey&key=$apiKey";
        return $this->callWebService("GET", $url, false);
    }
    public function openloadDownloadAPI($fileID, $ticket, $captcha){
        $url = "https://api.openload.co/1/file/dl?file=$fileID&ticket=$ticket&captcha_response=$captcha";
        return $this->callWebService("GET", $url, false);
    }
    
    public function googleAPI(){
        $link = 'https://photos.google.com/u/3/share/AF1QipNBR4FhwlXAleQmuT0qf6y0UXF4UtdSbL7jJAv7GJu8qxFVPL2bg5WEW30HX89MbQ/photo/AF1QipMMldPoVTFVXoEg85BPPQZF7QmRXcluP3-Xr9ym?key=bWM3Ums0SkJiVHVSTHNKME1NZmM4Z0w2ZXVmWmFR';
        $result = $this->getPhotoGoogle($link);
        print_r($result);
    }
       
}
