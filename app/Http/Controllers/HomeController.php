<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */    
    public function __construct()
    {
        $config = DB::table('config')->get();
        session(['PhimPerPage' => $config[0]->config_phim_per_page]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listTheLoai = DB::table('theloai')->get();
        $listNam     = DB::table('phim')->selectRaw('phim_nam as nam')->distinct()->orderBy('phim_nam')->get();
            
        $listPhimToday = DB::select(DB::raw('SELECT * FROM phim '
                . ' JOIN (SELECT DISTINCT phim_id FROM tap ORDER BY tap_ngaycapnhat DESC LIMIT 10) tap '
                . ' ON phim.phim_id IN (tap.phim_id) ORDER BY phim.phim_id DESC'));            
        for($i = 0; $i < count($listPhimToday); $i++){
            $listPhimToday[$i]->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat')
                    ->where('phim_id', $listPhimToday[$i]->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }        
        $htmlTapMoi = ClassCommon::getHTMLTapMoi(Session::get('PhimPerPage'),0);     
        
        $data['listTheLoai']    = $listTheLoai;
        $data['listNam']        = $listNam;        
        $data['listPhimToday']  = $listPhimToday;
        $data['htmlTapMoi']     = $htmlTapMoi;
        return view('home', $data);
    }
    
    public function xemThemTapMoi(){ 
        $phim_per_page = Session::get('PhimPerPage');
        if(Input::get('page') != null){
            $page  = Input::get('page')==0?1:Input::get('page');
            $offset = ($page-1) * $phim_per_page;            
            $htmlTapMoi = ClassCommon::getHTMLTapMoi($phim_per_page,$offset);
        } else {
            $htmlTapMoi = ClassCommon::getHTMLTapMoi($phim_per_page,0);
        }   
        return $htmlTapMoi;
    }
}
