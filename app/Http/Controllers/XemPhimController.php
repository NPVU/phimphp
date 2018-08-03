<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
/**
 * Description of XemPhimController
 *
 * @author npvu
 */
class XemPhimController extends Controller{
    //put your code here
    
    function getDataHeader(){
        $listTheLoai = DB::table('theloai')->get();
        $listNam     = DB::table('phim')->selectRaw('phim_nam as nam')->distinct()->get();
        $data['listTheLoai'] = $listTheLoai;
        $data['listNam']     = $listNam;
        return $data;
    }
    
    function xemPhim(){
        if(strcmp(Session::token(), Input::get('token')) == 0){
            $phim = DB::table('phim')->where('phim_id', Input::get('pid'))->get();
            $listTap = DB::table('tap')
                    ->selectRaw('tap_id, tap_ten, tap_tapso, tap_tapsohienthi, tap_luotxem')
                    ->where('phim_id', Input::get('pid'))->get();
            $tap_current = DB::table('tap')->where([
                        ['phim_id', Input::get('pid')],
                        ['tap_tapso', Input::get('t')]
                    ])->get();
            if(!empty($tap_current[0]->tap_googlelink)){
                $tap_current[0]->googleRedirectLink =  $this->getPhotoGoogle($tap_current[0]->tap_googlelink);
            }

            $data['phim'] = $phim;
            $data['listTap'] = $listTap;
            $data['tap'] = $tap_current;
            return view('xemphim', $data, $this->getDataHeader());   
        } else {
            $data['title'] = 'Không tìm thấy trang';
            $data['page'] = 'errors.404';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data);
        }
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
}
