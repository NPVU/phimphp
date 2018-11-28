<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    
    public function index(){        

        ClassCommon::processAccess();

        Cookie::queue('beforePhimID', 0);
        $htmlTapMoi = ClassCommon::getHTMLTapMoi(Session::get('PhimPerPage'),0);
        $htmlMovieMoi = ClassCommon::getHTMLMovieMoi(Session::get('PhimPerPage'),0);
        $data['htmlTapMoi']     = $htmlTapMoi;
        $data['htmlMovieMoi']     = $htmlMovieMoi;
        $data['listRandom']  = $this->getPhimRandom();
        return view('home_min', $data, parent::getDataHeader());
    }

    public function getGopY(){
        $data['captcha'] = captcha_img();
        return view('layouts.gopy_min', $data,parent::getDataHeader());
    }

    public function postGopY(Request $request){
        $rules = ['captcha' => 'required|captcha'];
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){
            $data['errorCaptcha'] = true;
            $data['captcha'] = captcha_img();
            
        }else{
            DB::table('feedback')->insert([               
                'feedback_content'    => trim($request->content),
                'feedback_create_at'  => now()
            ]);
            $data['reported'] = true;
        }
        return view('layouts.gopy_min', $data,parent::getDataHeader());
    }

    public function getBaoLoi(){
        $data['captcha'] = captcha_img();
        return view('layouts.baoloi_min', $data,parent::getDataHeader());
    }

    public function postBaoLoi(Request $request){
        $rules = ['captcha' => 'required|captcha'];
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){
            $data['errorCaptcha'] = true;
            $data['captcha'] = captcha_img();
            
        }else{
            DB::table('error_report')->insert([
                'phim_id'       => 0,
                'tap_id'        => 0,
                'er_url'        => trim($request->url),
                'er_content'    => trim($request->content),
                'er_create_at'  => now()
            ]);
            $data['reported'] = true;
        }
        return view('layouts.baoloi_min', $data,parent::getDataHeader());
    }

    public function getYeuCauPhim(){
        $data['captcha'] = captcha_img();
        return view('layouts.yeucau_min', $data,parent::getDataHeader());
    }

    public function postYeuCauPhim(Request $request){
        $rules = ['captcha' => 'required|captcha'];
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){
            $data['errorCaptcha'] = true;
            $data['captcha'] = captcha_img();
        }else{
            DB::table('yeucau')->insert([
                'yeucau_email'          => trim($request->email),
                'yeucau_content'        => trim($request->content),
                'yeucau_create_at'      => now()
            ]);
            $data['success'] = true;
        }
        return view('layouts.yeucau_min', $data,parent::getDataHeader());
    }
    
    public function postYeuCau(Request $request){
        
        DB::table('yeucau')->insert([
            'yeucau_email'          => trim($request->email),
            'yeucau_content'        => trim($request->content),
            'yeucau_create_at'      => now()
        ]);
        $data['success'] = true;
        
        
    }

    public function indexPhimTheoDoi(){
        if(Auth::check()){
            $listPhim = DB::table('phim')->whereRaw('phim_xuatban = 1 AND phim_id IN (SELECT phim_id FROM follow_phim WHERE user_id = '.Auth::id().')')
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

                $row->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $row->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
            }                                                    
            $data['listPhim'] = $listPhim;
            return view('userphim_min', $data, parent::getDataHeader());
        } else {
            $data['title'] = 'Không tìm thấy trang';
            $data['page'] = 'errors.404';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data);
        }        
    }

    public function indexTheLoai($theloai){
        $arrdata = explode('-', $theloai);
        $theloaiID = $arrdata[count($arrdata)-1];
        $theloai = DB::table('theloai')->where('theloai_id', $theloaiID)->get();
        $listPhimTheloai = DB::table('phim')->selectRaw('*, (SELECT tap_id FROM tap WHERE tap.phim_id = phim.phim_id ORDER BY tap_tapso ASC LIMIT 1) AS tap_id ')
                                        ->where([['theloai_id', 'like', '%"'.$theloaiID.'"%'], ['phim_xuatban', '=', 1]])
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->join('loaiphim', 'loaiphim.loaiphim_id', '=', 'phim.phim_kieu')
                                        ->paginate(Session::get('PhimPerPage'));
        foreach($listPhimTheloai as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }

            $row->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $row->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }                                        
        $data['theloai'] = $theloai;
        $data['listPhimTheloai'] = $listPhimTheloai;
        return view('theloai_min', $data, parent::getDataHeader());
    }

    public function indexQuocGia($quocgia){
        $arrdata = explode('-', $quocgia);
        $quocgiaID = $arrdata[count($arrdata)-1];
        $quocgia = DB::table('quocgia')->where('quocgia_id', $quocgiaID)->get();
        $listPhimQuocGia = DB::table('phim')->selectRaw('*, (SELECT tap_id FROM tap WHERE tap.phim_id = phim.phim_id ORDER BY tap_tapso ASC LIMIT 1) AS tap_id ')
                                        ->where([['phim.quocgia_id', '=', $quocgiaID], ['phim_xuatban', '=', 1]])
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->join('loaiphim', 'loaiphim.loaiphim_id', '=', 'phim.phim_kieu')
                                        ->paginate(Session::get('PhimPerPage'));
        
        foreach($listPhimQuocGia as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }

            $row->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $row->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }    
        $data['quocgia'] = $quocgia;
        $data['listPhimQuocGia'] = $listPhimQuocGia;
        return view('quocgia_min', $data, parent::getDataHeader());
    }

    public function indexXemNhieu(){        
        $listPhimXemNhieu = DB::table('phim')->selectRaw('*, (SELECT tap_id FROM tap WHERE tap.phim_id = phim.phim_id ORDER BY tap_tapso ASC LIMIT 1) AS tap_id ')
                                        ->where('phim_xuatban', 1)
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->join('loaiphim', 'loaiphim.loaiphim_id', '=', 'phim.phim_kieu')
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

            $row->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $row->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        } 
        $data['listPhimXemNhieu'] = $listPhimXemNhieu;
        return view('xemnhieu_min', $data, parent::getDataHeader());      
    }

    public function indexTvSeries(){
        $listPhim = DB::table('phim')->selectRaw('*, (SELECT tap_id FROM tap WHERE tap.phim_id = phim.phim_id ORDER BY tap_tapso ASC LIMIT 1) AS tap_id ')
                                        ->where('phim_kieu', 1)
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->join('loaiphim', 'loaiphim.loaiphim_id', '=', 'phim.phim_kieu')
                                        ->paginate(Session::get('PhimPerPage'));                
        foreach($listPhim as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }

            $row->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $row->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }           
        $data['kieuphim'] = 'TV Series'; 
        $data['listPhim'] = $listPhim;
        return view('kieuphim_min', $data, parent::getDataHeader());
    }

    public function indexMovie(){
        $listPhim = DB::table('phim')->selectRaw('*, (SELECT tap_id FROM tap WHERE tap.phim_id = phim.phim_id ORDER BY tap_tapso ASC LIMIT 1) AS tap_id ')
                                        ->where('phim_kieu', 2)
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->join('loaiphim', 'loaiphim.loaiphim_id', '=', 'phim.phim_kieu')
                                        ->paginate(Session::get('PhimPerPage'));                
        foreach($listPhim as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }

            $row->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $row->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }            
        $data['kieuphim'] = 'Movie';
        $data['listPhim'] = $listPhim;
        return view('kieuphim_min', $data, parent::getDataHeader());
    }

    public function indexOva(){
        $listPhim = DB::table('phim')->selectRaw('*, (SELECT tap_id FROM tap WHERE tap.phim_id = phim.phim_id ORDER BY tap_tapso ASC LIMIT 1) AS tap_id ')
                                        ->where('phim_kieu', 3)
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->join('loaiphim', 'loaiphim.loaiphim_id', '=', 'phim.phim_kieu')
                                        ->paginate(Session::get('PhimPerPage'));                
        foreach($listPhim as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }

            $row->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $row->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }            
        $data['kieuphim'] = 'Ova';
        $data['listPhim'] = $listPhim;
        return view('kieuphim_min', $data, parent::getDataHeader());
    }

    public function indexLiveAction(){
        $listPhim = DB::table('phim')->selectRaw('*, (SELECT tap_id FROM tap WHERE tap.phim_id = phim.phim_id ORDER BY tap_tapso ASC LIMIT 1) AS tap_id ')
                                        ->where('phim_kieu', 4)
                                        ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                        ->join('loaiphim', 'loaiphim.loaiphim_id', '=', 'phim.phim_kieu')
                                        ->paginate(Session::get('PhimPerPage'));                
        foreach($listPhim as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                $row->listTheLoai .=  $listTheLoaiPhim[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiPhim)?', ':'.';
            }

            $row->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $row->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
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
        $listRandom = DB::table('phim')->selectRaw('*, (SELECT tap_id FROM tap WHERE tap.phim_id = phim.phim_id ORDER BY tap_tapso ASC LIMIT 1) AS tap_id ')
                ->where('phim_xuatban', 1)->orderByRaw('RAND()')
                ->limit(10)
                ->get();
        return $listRandom;
    }
}
