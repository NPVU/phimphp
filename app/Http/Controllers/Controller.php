<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        $listTheLoai = DB::table('theloai')->get();
        $listNam     = DB::table('phim')->selectRaw('phim_nam as nam')->distinct()->orderBy('phim_nam')->get();
        $htmlTapMoi = ClassCommon::getHTMLTapMoi(Session::get('PhimPerPage'),0);
        $phimXepHangTuan = ClassCommon::getBangXepHang('week', 10, 0);
        $phimXepHangThang = ClassCommon::getBangXepHang('month', 10, 0);
        
        $data['listTheLoai'] = $listTheLoai;
        $data['listNam']     = $listNam;
        $data['htmlTapMoi']     = $htmlTapMoi;
        $data['phimXepHangTuan']     = $phimXepHangTuan;
        $data['phimXepHangThang']     = $phimXepHangThang;
        return $data;
    }
}
