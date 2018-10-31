<?php



namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller {
    
    public function getSourceFacebook(){        
        
        $tap = DB::table('tap')->where('tap_id', Input::get('tapid'))->get();
        
        $videoID = $tap[0]->tap_facebooklink;

        $get = $this->curl("https://www.facebook.com/video/embed?video_id=".$videoID);
        $dataTemp = explode('hd_src":"', $get);
        $data = explode('","sd_src":"', $dataTemp[1]);
        $video['hd'] = $data[0];
        $video['sd'] = explode('","hd_tag":"', $data[1])[0];
        $video['hd'] = 'https://scontent.xx.fbcdn.net/v/t42.9040-2/'.explode('\/',($video['hd']))[5];
        $video['sd'] = 'https://scontent.xx.fbcdn.net/v/t42.9040-2/'.explode('\/',(explode('","hd_tag":"', $data[1])[0]))[5];
        return $video;
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
    
}
