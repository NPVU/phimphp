<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    
    public function index(){        
        $htmlTapMoi = ClassCommon::getHTMLTapMoi(Session::get('PhimPerPage'),0);
        $htmlMovieMoi = ClassCommon::getHTMLMovieMoi(Session::get('PhimPerPage'),0);
        $data['htmlTapMoi']     = $htmlTapMoi;
        $data['htmlMovieMoi']     = $htmlMovieMoi;
        $data['listRandom']  = $this->getPhimRandom();
        return view('home_min', $data, parent::getDataHeader());
    }

    public function indexTheLoai($theloai){
        $arrdata = explode('-', $theloai);
        $theloaiID = $arrdata[count($arrdata)-1];
        $theloai = DB::table('theloai')->where('theloai_id', $theloaiID)->get();
        $listPhimTheloai = DB::table('phim')->where([['theloai_id', 'like', '%"'.$theloaiID.'"%'], ['phim_xuatban', '=', 1]])
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->paginate(Session::get('PhimPerPage'));
        foreach($listPhimTheloai as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }
        }                                        
        $data['theloai'] = $theloai;
        $data['listPhimTheloai'] = $listPhimTheloai;
        return view('theloai_min', $data, parent::getDataHeader());
    }

    public function indexQuocGia($quocgia){
        $arrdata = explode('-', $quocgia);
        $quocgiaID = $arrdata[count($arrdata)-1];
        $quocgia = DB::table('quocgia')->where('quocgia_id', $quocgiaID)->get();
        $listPhimQuocGia = DB::table('phim')->where([['phim.quocgia_id', '=', $quocgiaID], ['phim_xuatban', '=', 1]])
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->paginate(Session::get('PhimPerPage'));
        
        foreach($listPhimQuocGia as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }
        }    
        $data['quocgia'] = $quocgia;
        $data['listPhimQuocGia'] = $listPhimQuocGia;
        return view('quocgia_min', $data, parent::getDataHeader());
    }

    public function indexXemNhieu(){        
        $listPhimXemNhieu = DB::table('phim')->where('phim_xuatban', 1)->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->orderByRaw('phim_luotxem DESC')
                                        ->paginate(Session::get('PhimPerPage'));     
                                    
        foreach($listPhimXemNhieu as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }
        } 
        $data['listPhimXemNhieu'] = $listPhimXemNhieu;
        return view('xemnhieu_min', $data, parent::getDataHeader());      
    }

    public function indexTvSeries(){
        $listPhim = DB::table('phim')->where('phim_kieu', 'TV Series')
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->paginate(Session::get('PhimPerPage'));                
        foreach($listPhim as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }
        }           
        $data['kieuphim'] = 'TV Series'; 
        $data['listPhim'] = $listPhim;
        return view('kieuphim_min', $data, parent::getDataHeader());
    }

    public function indexMovie(){
        $listPhim = DB::table('phim')->where('phim_kieu', 'Movie')
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->paginate(Session::get('PhimPerPage'));                
        foreach($listPhim as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }
        }            
        $data['kieuphim'] = 'Movie';
        $data['listPhim'] = $listPhim;
        return view('kieuphim_min', $data, parent::getDataHeader());
    }

    public function indexOva(){
        $listPhim = DB::table('phim')->where('phim_kieu', 'Ova')
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->paginate(Session::get('PhimPerPage'));                
        foreach($listPhim as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }
        }            
        $data['kieuphim'] = 'Ova';
        $data['listPhim'] = $listPhim;
        return view('kieuphim_min', $data, parent::getDataHeader());
    }

    public function indexLiveAction(){
        $listPhim = DB::table('phim')->where('phim_kieu', 'Live Action')
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->paginate(Session::get('PhimPerPage'));                
        foreach($listPhim as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }
        }            
        $data['kieuphim'] = 'Live Action';
        $data['listPhim'] = $listPhim;
        return view('kieuphim_min', $data, parent::getDataHeader());
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

    public function xemThemMovieMoi(){ 
        $phim_per_page = Session::get('PhimPerPage');
        if(Input::get('page') != null){
            $page  = Input::get('page')==0?1:Input::get('page');
            $offset = ($page-1) * $phim_per_page;            
            $html = ClassCommon::getHTMLMovieMoi($phim_per_page,$offset);
        } else {
            $html = ClassCommon::getHTMLMovieMoi($phim_per_page,0);
        }   
        return $html;
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
