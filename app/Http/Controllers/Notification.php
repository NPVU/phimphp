<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as Controller;

class Notification extends Controller{       
    public static function sendNotificationOfPhim($phimID, $tap, $taphienthi){
        $phim = DB::table('phim')->where('phim_id', $phimID)->get();        
        $listUserID = DB::table('follow_phim')->where('phim_id', $phimID)->get();
        foreach($listUserID as $row){
            DB::table('notification')->insert([
                'notify_url'             => URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten)))).'/?pid='.$phimID.'&t='.$tap.'&s='.md5('google'),
                'notify_image'           => trim($phim[0]->phim_hinhanh),
                'notify_title'           => trim($phim[0]->phim_ten),
                'notify_content'         => $taphienthi.' vừa được cập nhật',
                'user_id'                => $row->user_id,
                'phim_id'                => $phimID,
                'notify_flag'            => 1,
                'notify_create_at'       => now()
            ]);
        }
    }

    public static function getNotificationForUser(){
        return DB::table('notification')->where('user_id', Auth::id())->orderByRaw('notify_id DESC')->get();
    }

    public static function removeNotificationForUserOfPhim($phimID){
        DB::table('notification')->where([['phim_id','=',$phimID],['user_id','=',Auth::id()]])->delete();
    }
}

