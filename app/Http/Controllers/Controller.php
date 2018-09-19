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

        $config_website = DB::table('config_website')->get();
        session(['website_name' => $config_website[0]->cw_name]);
        session(['website_email' => $config_website[0]->cw_email]);
        session(['website_domain' => $config_website[0]->cw_domain]);
        session(['website_phone' => $config_website[0]->cw_phone]);
        session(['website_address' => $config_website[0]->cw_address]);
        session(['website_company' => $config_website[0]->cw_company]);        
        session(['website_author' => $config_website[0]->cw_author]);
        session(['website_version' => $config_website[0]->cw_version]);
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
