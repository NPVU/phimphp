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
use Illuminate\Support\Facades\Cookie;
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
    
    function xemPhim($url, $tapid){
        $tapid = explode('.', $tapid)[0];
        $check = true;
        $tap_current = DB::table('tap')->where('tap_id', $tapid)->get();          
        
        if (count($tap_current) <= 0) {
            $tap_current = DB::table('tap')->where('phim_id', $phim_id)->orderByRaw('tap_tapso ASC')->limit(1)->get();        
        }    

        $phim_id = $tap_current[0]->phim_id;
        $phim = DB::table('phim')->where('phim_id', $phim_id)
                ->join('quocgia','quocgia.quocgia_id','=','phim.quocgia_id')
                ->join('loaiphim', 'loaiphim.loaiphim_id', '=', 'phim.phim_kieu')
                ->get();
        $idTheLoai = json_decode($phim[0]->theloai_id);
        $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();

        $star = ClassCommon::getStar($phim_id);
        $voteTimes = ClassCommon::getVoteTimes($phim_id);       
        $listSeason = $this->getListSeason($phim_id, $phim[0]->phim_tag);
        foreach($listSeason as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiSeason = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiSeason); $i++){
                $row->listTheLoai .=  $listTheLoaiSeason[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiSeason)?', ':'.';
            }
            $row->tap = DB::table('tap')
                    ->selectRaw('tap_id, tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $row->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }
        $listGoiY = $this->getListGoiY($phim[0]);
        foreach($listGoiY as $row){
            $row->listTheLoai = '';
            $idTheLoai = json_decode($row->theloai_id);
            $listTheLoaiGoiY = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
            for($i = 0; $i < count($listTheLoaiGoiY); $i++){
                $row->listTheLoai .=  $listTheLoaiGoiY[$i]->theloai_ten;
                $row->listTheLoai .=  $i+1<count($listTheLoaiGoiY)?', ':'.';
            }
            $row->tap = DB::table('tap')
                    ->selectRaw('tap_id, tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $row->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }
        $follow = 0;
        $followAmount = 0;
        //if(Auth::check()){
        //   $follow = DB::table('follow_phim')->where([['phim_id','=',Input::get('pid')], ['user_id','=',Auth::id()]])->count();
        //   NotificationUtils::removeNotificationForUserOfPhim(Input::get('pid'));
        //}
        //$followAmount = DB::table('follow_phim')->where('phim_id', $phim[0]->phim_id)->count();
        if($check){            
            $data['phim'] = $phim;
            $data['listTheLoaiPhim'] = $listTheLoaiPhim;
            $data['listTapVS'] = $this->getListTapVietsub($phim_id); 
            $data['listTapTM'] = $this->getListTapThuyetMinh($phim_id);
            $data['tap'] = $tap_current;
            $data['star'] = $star;
            $data['voteTimes'] = $voteTimes;            
            $data['listSeason'] = $listSeason;
            $data['listGoiY'] = $listGoiY;
            $data['follow_phim'] = $follow;
            $data['follows'] = $followAmount;            
            $data['cookiePhim'] = $this->getCookieXemPhim($phim_id, $tapid, $tap_current[0]->tap_tapso);

            return view('xemphim_min', $data, parent::getDataHeader()); 
        } else {
            $data['title'] = 'Không tìm thấy trang';
            $data['page'] = 'errors.404';
            if(!isset($phim)){
                $data['backURL'] = URL::to('/');
            } else {
                $data['backURL'] = URL::to('/xem-phim'.strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))).'?pid='.$phim[0]->phim_id.'&t=1&s='.md5('google').'&token='.Session::token());
            }
            return view('errors/index', $data);
        }
    }

    public function getListTapVietsub($phim_id){
        return DB::table('tap')->selectRaw('tap_id, tap_ten, tap_tapso, tap_tapsohienthi, tap_luotxem')
                        ->where([['phim_id', $phim_id],['tap_thuyetminh', 0]])->orderBy('tap_tapso')->get(); 
    }

    public function getListTapThuyetMinh($phim_id){
        return DB::table('tap')->selectRaw('tap_id, tap_ten, tap_tapso, tap_tapsohienthi, tap_luotxem')
                        ->where([['phim_id', $phim_id],['tap_thuyetminh', 1]])->orderBy('tap_tapso')->get();
    }

    public function getListSeason($phimID, $phimTag){
        $listSeason = DB::select(DB::raw('SELECT *, (SELECT tap_id FROM tap WHERE tap.phim_id = phim.phim_id ORDER BY tap_tapso ASC LIMIT 1) AS tap_id FROM phim '
                . ' LEFT JOIN quocgia ON phim.quocgia_id = quocgia.quocgia_id'
                . ' LEFT JOIN loaiphim ON phim.phim_kieu = loaiphim.loaiphim_id'
                . ' WHERE phim_xuatban = 1 AND phim_tag like "%'.$phimTag.'%" '
                . ' ORDER BY phim_nam ASC')); 
        return $listSeason;
    }

    public function getListGoiY($phim){
        return DB::table('phim')
        ->selectRaw('*, (SELECT tap_id FROM tap WHERE tap.phim_id = phim.phim_id ORDER BY tap.tap_tapso ASC LIMIT 1) AS tap_id ')
        ->join('quocgia','quocgia.quocgia_id','=','phim.quocgia_id')
        ->join('loaiphim', 'loaiphim.loaiphim_id', '=', 'phim.phim_kieu')
        ->where([['phim.quocgia_id', $phim->quocgia_id],['phim_kieu', $phim->phim_kieu],['phim_id', '!=', $phim->phim_id], ['phim_tag', '!=', $phim->phim_tag], ['phim_xuatban', 1]])
        ->orderByRaw('RAND()')
        ->limit(8)
        ->get();
    }

    public function loadVideo(){
        
            $tap_current = DB::table('tap')->where('tap_id', Input::get('id'))->get();
            if (!empty($tap_current[0]->tap_googlelink)) {               
                return $this->getPhotoGoogle($tap_current[0]->tap_googlelink);
            } else {
                return null;
            }
       
    }
    
    public function addLuotXem(){
            $tap = DB::table('tap')->where('tap_id', Input::get('id'))->get();
            ClassCommon::addLuotXem($tap[0]->phim_id, $tap[0]->tap_id);            
            $luotxem = DB::table('tap')->selectRaw('tap_luotxem, tap_id')->where([
                        ['phim_id', $tap[0]->phim_id],
                        ['tap_id', $tap[0]->tap_id]
                ])->get();
            $phim = DB::table('phim')->selectRaw('phim_luotxem, phim_luotxem_tuan, phim_luotxem_thang')->where('phim_id', $tap[0]->phim_id)->get();
            $data['event']      = 'view';
            $array['tapid']     = $luotxem[0]->tap_id;
            $array['tview']     = ClassCommon::formatLuotXem($luotxem[0]->tap_luotxem);
            $array['phimid']    = $tap[0]->phim_id;
            $array['pview']     = ClassCommon::formatLuotXem($phim[0]->phim_luotxem);
            $array['pviewweek'] = ClassCommon::formatLuotXem($phim[0]->phim_luotxem_tuan);
            $array['pviewmonth']= ClassCommon::formatLuotXem($phim[0]->phim_luotxem_thang);
            $array['pstrview']  = ClassCommon::demLuotXem($phim[0]->phim_luotxem);
            $data['content']    = $array;
            event(new PusherEvent($data));            
        
    }

    public function autoNext(){
        if(strcmp(Input::get('value'),'1')==0){
            session(['autoNext' => 0]);
        }else{
            session(['autoNext' => 1]);
        }        
    }
    
    public function addDanhGia() {      
        if(strcmp(Session::token(), Input::get('token'))==0){
            $phim_id = Input::get('pid');
            DB::table('danhgia')->insert([
                'phim_id' => $phim_id,
                'danhgia_star' => floatval(Input::get('star')),
                'danhgia_ngay' => now()
            ]);
            $data['times'] = DB::table('danhgia')->where('phim_id', $phim_id)->count();
            $data['star'] = ClassCommon::getStar($phim_id);
            $data['status'] = 1;
            session(['voted' => $phim_id.','.Session::get('voted')]);
        }else{
            $data['status'] = 0;
            $data['message'] = 'Sai token';
        }
        return $data;
        
    }

    public function reportError(Request $request){
        if(strcmp(Session::token(), $request->_token) == 0){
            $tap = DB::table('tap')->where([
                ['phim_id', $request->pid],
                ['tap_id', $request->t]
            ])->get();
            $countReport = DB::table('error_report')->where([['phim_id', '=', $request->pid], ['tap_id','=',$tap[0]->tap_id]])->count();
            if($countReport < 5){
                if(count($tap)){
                    DB::table('error_report')->insert([
                        'phim_id' => $request->pid,
                        'tap_id' => $tap[0]->tap_id,
                        'er_url' => '',
                        'er_content' => $request->content,
                        'er_create_at' => now()
                    ]);
                }
            }            
        }
    }

    public function followPhim(Request $request){
        if (Auth::check()) {
            $count = DB::table('follow_phim')->where([['phim_id','=',$request->pid], ['user_id','=',Auth::id()]])->count();
            if($count == 0){
                DB::table('follow_phim')->insert([
                    'phim_id' => $request->pid,
                    'user_id' => Auth::id(),
                    'fp_flag' => 0
                ]);
            } 
            return DB::table('follow_phim')->where('phim_id', $request->pid)->count();          
        } else {
            return -1;
        }
    }

    public function unfollowPhim(Request $request){
        DB::table('follow_phim')->where([['phim_id','=',$request->pid], ['user_id','=',Auth::id()]])->delete();
        return DB::table('follow_phim')->where('phim_id', $request->pid)->count();
    }
    
    public function confirmAge(){
        if(Session::has('confirmAge')){
            $arrayAge = Session::get('confirmAge');
        }else{
            $arrayAge = array();
        }        
        array_push($arrayAge, Input::get('pid'));
        session(['confirmAge' => $arrayAge]);
    }

    public function getCookieXemPhim($phim_id, $tap_id, $tapso){     
        $data['openCookie'] = false;           
        
        /* 
            Nếu beforePhimID == phim_id tức là đang xem cùng 1 bộ phim => không cần cookie
            Nếu beforePhimID !== phim_id tức là phim xem lần trước là phim khác 
                (hoặc lần truy cập này chưa xem phim nào, hoặc trở về trang chủ) => cần kiểm tra cookie
        */
        if(Cookie::get('beforePhimID') != $phim_id){
            /*
                Nếu phim đang xem là lần đâu tiên xem => == null => không cần cookie
                Nếu phim đang xem đã có xem vào thời điểm nào đó rồi => !== null => cần kiểm tra cookie
            */
            if(Cookie::get('cookiePhimID-'.$phim_id) != null){
                /*
                    Lấy tập phim lần cuối người này xem
                    Lấy móc thời gian lần cuối của tập phim 
                */
                $json = json_decode(Cookie::get('cookiePhimID-'.$phim_id));
                if($tapso <= $json->tapso){
                    $data['tapID'] = $json->tap_id;
                    $data['time'] = isset($json->time)?$json->time:0;
                    $data['timeDisplay'] = ClassCommon::formatSeconds(isset($json->time)?$json->time:0);
                    $data['tapSoHienThi'] = $json->tapsohienthi;
                    $data['openCookie'] = true;
                }                
            }
        }        
        return $data;
    }
    
    public function setCookieXemPhim(){
        $tap_id = Input::get('t');
        $tap = DB::table('tap')->where('tap_id', $tap_id)->get();
        $data['tap_id'] = $tap_id;
        $data['time']   = Input::get('time');
        $data['tapso']  = $tap[0]->tap_tapso;
        $data['tapsohienthi']  = $tap[0]->tap_tapsohienthi;
        Cookie::queue('beforePhimID', $tap[0]->phim_id);
        Cookie::queue('cookiePhimID-'.$tap[0]->phim_id, json_encode($data));
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
