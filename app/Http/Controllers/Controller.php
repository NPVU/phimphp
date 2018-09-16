<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;  
    public function __construct()
    {
        $config = DB::table('config')->get();
        session(['PhimPerPage' => $config[0]->config_phim_per_page]);
        session(['CommentPerPage' => $config[0]->config_comment_per_page]);
    }
    public function getDataHeader(){                      
        $phimXepHangTuan = ClassCommon::getBangXepHang('week', 10, 0);
        $phimXepHangThang = ClassCommon::getBangXepHang('month', 10, 0);

        if(Auth::check()){
            $notification = NotificationUtils::getNotificationForUser();
            $data['notification'] = $notification;
        }                                
        $data['phimXepHangTuan']     = $phimXepHangTuan;
        $data['phimXepHangThang']     = $phimXepHangThang;
        return $data;
    }
}
