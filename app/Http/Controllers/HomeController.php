<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index(){        
        $htmlTapMoi = ClassCommon::getHTMLTapMoi(Session::get('PhimPerPage'),0);
        $data['htmlTapMoi']     = $htmlTapMoi;
        $data['listRandom']  = $this->getPhimRandom();
        return view('home_min', $data, parent::getDataHeader());
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
    
    public function timKiem(Request $request){
        return ClassCommon::getHTMLTimKiem($request->tukhoa);
    }

    public function getPhimRandom(){
        $limit = 10;
        if(is_null(Session::get('sliderOffsets'))){
            $count = DB::table('phim')->where('phim_xuatban', 1)->count();            
            if($count > $limit){
                $offset = rand(0, $count-$limit);
            }else{
                $offset = 0;
            }
            session(['sliderOffsets' => $offset]);
        }
                
        $listRandom = DB::table('phim')->where('phim_xuatban', 1)->offset(Session::get('sliderOffsets'))->limit($limit)->get();
        return $listRandom;
    }
}
