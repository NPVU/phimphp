<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    
    public function index(){        
        $listPhimToday = DB::select(DB::raw('SELECT * FROM phim '
                . ' JOIN (SELECT DISTINCT phim_id FROM tap ORDER BY tap_ngaycapnhat DESC LIMIT 10) tap '
                . ' ON phim.phim_id IN (tap.phim_id) ORDER BY phim.phim_id DESC'));            
        for($i = 0; $i < count($listPhimToday); $i++){
            $listPhimToday[$i]->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat')
                    ->where('phim_id', $listPhimToday[$i]->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
                    
            $star = ClassCommon::getStar($listPhimToday[$i]->phim_id);
            $listPhimToday[$i]->star = $star;
        }                     
                
        $data['listPhimToday']  = $listPhimToday;        
        return view('home', $data, parent::getDataHeader());
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
    
    public function xemThemTheLoai(){ 
        $phim_per_page = Session::get('PhimPerPage');
        if(Input::get('page') != null){
            $page  = Input::get('page')==0?1:Input::get('page');
            $offset = ($page-1) * $phim_per_page;            
            $htmlTapMoi = ClassCommon::getHTMLTheLoai(Input::get('theloai'),$phim_per_page,$offset);
        } else {
            $htmlTapMoi = ClassCommon::getHTMLTheLoai(Input::get('theloai'),$phim_per_page,0);
        }   
        return $htmlTapMoi;
    }
    
    public function xemThemNam(){ 
        $phim_per_page = Session::get('PhimPerPage');
        if(Input::get('page') != null){
            $page  = Input::get('page')==0?1:Input::get('page');
            $offset = ($page-1) * $phim_per_page;            
            $htmlTapMoi = ClassCommon::getHTMLNam(Input::get('nam'),$phim_per_page,$offset);
        } else {
            $htmlTapMoi = ClassCommon::getHTMLNam(Input::get('nam'),$phim_per_page,0);
        }   
        return $htmlTapMoi;
    }
    
    public function xemThemBangXepHang(){ 
        $phim_per_page = Session::get('PhimPerPage');
        if(Input::get('page') != null){
            $page  = Input::get('page')==0?1:Input::get('page');
            $offset = ($page-1) * $phim_per_page;            
            $htmlTapMoi = ClassCommon::getHTMLBangXepHang(Input::get('time'),$phim_per_page,$offset);
        } else {
            $htmlTapMoi = ClassCommon::getHTMLBangXepHang(Input::get('time'),$phim_per_page,0);
        }   
        return $htmlTapMoi;
    }
}
