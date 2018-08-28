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
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\PusherEvent;
/**
 * Description of XemPhimController
 *
 * @author npvu
 */
class XemPhimController extends Controller{
    //put your code here        
    
    function hasRole(){
        $user = Auth::user();
        $hasRole = DB::table('users_roles')->whereRaw('user_id = '.$user->id.' AND (role_code = '.RoleUtils::getRoleSuperAdmin().' OR role_code = '.RoleUtils::getRoleAdminPhim().')')->count();
        return $hasRole>0?true:false;
    }
    
    function xemPhim(){
        $check = true;

        $phim = DB::table('phim')->where('phim_id', Input::get('pid'))->get();
        $idTheLoai = json_decode($phim[0]->theloai_id);
        $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
        $listTap = DB::table('tap')
                        ->selectRaw('tap_id, tap_ten, tap_tapso, tap_tapsohienthi, tap_luotxem')
                        ->where('phim_id', Input::get('pid'))->get();
        $tap_current = DB::table('tap')->where([
                        ['phim_id', Input::get('pid')],
                        ['tap_tapso', Input::get('t')]
                ])->get();        
        if (count($tap_current) > 0) {
            
        } else {
            $check = false;
        }        
        $star = ClassCommon::getStar(Input::get('pid'));
        $comment = CommentUtils::getHTMLComment(Input::get('pid'),Session::get('CommentPerPage'),0);
        if($check){            
            $data['phim'] = $phim;
            $data['listTheLoaiPhim'] = $listTheLoaiPhim;
            $data['listTap'] = $listTap;
            $data['tap'] = $tap_current;
            $data['star'] = $star;
            $data['comment'] = $comment;
            return view('xemphim', $data, parent::getDataHeader()); 
        } else {
            $data['title'] = 'Không tìm thấy trang';
            $data['page'] = 'errors.404';
            if(!isset($phim)){
                $data['backURL'] = URL::to('/');
            } else {
                $data['backURL'] = URL::to('/xem-phim/'.strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))).'?pid='.$phim[0]->phim_id.'&t=1&s='.md5('google').'&token='.Session::token());
            }
            return view('errors/index', $data);
        }
    }    

    public function loadVideo(){
        if(strcmp(Session::token(), Input::get('token')) == 0){
            $tap_current = DB::table('tap')->where([
                            ['phim_id', Input::get('pid')],
                            ['tap_tapso', Input::get('t')]
                    ])->get();
            if (!empty($tap_current[0]->tap_googlelink)) {
                return $this->getPhotoGoogle($tap_current[0]->tap_googlelink);
            } else {
                return null;
            }
        } else {
            $data['title'] = 'Không tìm thấy trang';
            $data['page'] = 'errors.404';            
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data);
        }
    }
    
    public function addLuotXem(){
        if(strcmp(Session::token(), Input::get('token')) == 0){
            ClassCommon::addLuotXem(Input::get('pid'), Input::get('t'));            
            $luotxem = DB::table('tap')->selectRaw('tap_luotxem, tap_id')->where([
                        ['phim_id', Input::get('pid')],
                        ['tap_tapso', Input::get('t')]
                ])->get();
            $phim = DB::table('phim')->selectRaw('phim_luotxem, phim_luotxem_tuan, phim_luotxem_thang')->where('phim_id', Input::get('pid'))->get();
            $data['event']      = 'view';
            $array['tapid']     = $luotxem[0]->tap_id;
            $array['tview']     = ClassCommon::formatLuotXem($luotxem[0]->tap_luotxem);
            $array['phimid']    = Input::get('pid');
            $array['pview']     = ClassCommon::formatLuotXem($phim[0]->phim_luotxem);
            $array['pviewweek'] = ClassCommon::formatLuotXem($phim[0]->phim_luotxem_tuan);
            $array['pviewmonth']= ClassCommon::formatLuotXem($phim[0]->phim_luotxem_thang);
            $array['pstrview']  = ClassCommon::demLuotXem($phim[0]->phim_luotxem);
            $data['content']    = $array;
            event(new PusherEvent($data));            
        }
    }
    
    public function addDanhGia() {
        if (Auth::check()) {
            $user = Auth::user();
            DB::table('danhgia')->where('user_id', $user->id)->where('phim_id', Input::get('pid'))->delete();
            DB::table('danhgia')->insert([
                'user_id' => $user->id,
                'phim_id' => Input::get('pid'),
                'danhgia_star' => floatval(Input::get('star')),
                'danhgia_ngay' => now()
            ]);
            return 1;
        } else {
            return -1;
        }
    }

    public function comment(Request $request){
        if(strcmp(Session::token(), $request->token) == 0){
            if (Auth::check()) {
                $user = Auth::user();                
                DB::table('binhluan')->insert([
                    'binhluan_noidung' => $request->content,
                    'phim_id' => $request->pid,
                    'user_id' => $user->id,
                    'binhluan_ngaycapnhat' => now()
                ]);
                return CommentUtils::getHTMLComment($request->pid, Session::get('CommentPerPage'), 0);
            } else {
                return -1;
            }               
        } else {
            return 0;
        }
    }
    public function replyComment(Request $request){
        if (Auth::check()) {
            $user = Auth::user();      
            $binhluan = DB::table('binhluan')->where('binhluan_id', $request->cid)->get();          
            DB::table('binhluan')->insert([
                'binhluan_noidung' => $request->content,
                'phim_id' => $binhluan[0]->phim_id,
                'user_id' => $user->id,
                'binhluan_id_cha' => $request->cid,
                'binhluan_ngaycapnhat' => now()
            ]);
            $commentPerPage = Session::get('CommentPerPage') * ($request->page - 1);
            return CommentUtils::getHTMLComment($binhluan[0]->phim_id, $commentPerPage, 0);
        } else {
            return -1;
        }
    }
    
    public function deleteComment(Request $request){
        if($this->hasRole()){
            DB::table('binhluan')->where('binhluan_id', $request->cid)->delete();
        }
    }

    public function xemThemComment(){
        $comment_per_page = Session::get('CommentPerPage');
        if(Input::get('page') != null){
            $page  = Input::get('page')==0?1:Input::get('page');
            $offset = ($page-1) * $comment_per_page;            
            $comment = CommentUtils::getHTMLComment(Input::get('pid'),$comment_per_page,$offset);
        } else {
            $comment = CommentUtils::getHTMLComment(Input::get('pid'),$comment_per_page,0);
        }   
        return $comment;
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
        if(count($data) > 1){
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
        } else {
            return null;
        }
    }
}
