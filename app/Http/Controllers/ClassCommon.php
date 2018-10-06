<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Events\PusherEvent;
class ClassCommon extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public static function nullOrEmptyString($str){
        return (!isset($str) || trim($str) === '');
    }
    
    public static function getPathUploadAvatar(){
        return 'upload/avatar/';
    }
    
    public static function getPathUploadImage(){
        return 'upload/image/';
    }
    
    public static function getPathUploadTemp(){
        return 'upload/temp/';
    }
    
    public static function addLuotXem($phimID, $tap){
        DB::table('tap')->where([
                        ['phim_id', $phimID],
                        ['tap_tapso', $tap]
                    ])->update([
                        'tap_luotxem' => DB::raw('tap_luotxem + 1')
                    ]);        
        self::updateLuotXem($phimID);
    }
    
    public static function updateLuotXem($phimID){
        DB::table('phim')->where('phim_id', $phimID)->update([
            'phim_luotxem'  => DB::raw('(SELECT SUM(tap_luotxem) FROM tap WHERE tap.phim_id = '.$phimID.')'),
            'phim_luotxem_tuan'  => DB::raw('(SELECT phim_luotxem_tuan + 1 )'),
            'phim_luotxem_thang'  => DB::raw('(SELECT phim_luotxem_thang + 1 )')
        ]);
    }
    
    public static function getStrSoNgayDaQua($str){
        $date = date(strtotime($str));
        $day1 = date('d-m-Y H:i:s', $date);
        $day2 = date('d-m-Y H:i:s', time());
        $s = strtotime($day2) - strtotime($day1);
        $phut   = 60;
        $gio    = $phut*60;
        $ngay   = $gio*24;
        $tuan   = $ngay*7;
        $thang  = $tuan*4;        
        $nam    = $thang*12;
        $result = '1 phút trước';
        if(($s/$nam)>=1){
            $result = round($s/$nam).' năm trước';
        } else if(($s/$thang)>=1){
            $result = round($s/$thang).' tháng trước';
        } else if(($s/$tuan)>=1){
            $result = round($s/$tuan).' tuần trước';
        } else if(($s/$ngay)>=1){
            $result = round($s/$ngay).' ngày trước';
        } else if(($s/$gio)>=1){
            $result = round($s/$gio).' giờ trước';
        } else if(($s/$phut)>=1){
            $result = round($s/$phut).' phút trước';
        }                
        return $result;
    }
    
    public static function demLuotXem($n){
        $str = $n;
        $k = 1000;
        $m = $k*1000;
        if($n / $m > 1){
            $str = round($n/$m). ' Tr';
        } else if($n / $k > 1){
            $str = round($n/$k). ' N';
        }
        return $str;
    }
    
    public static function formatLuotXem($n){
        return number_format($n);
    }
    
    public static function getHTMLTapMoi($limit, $offset){
        $listPhimToday = DB::table('phim')->where([['phim_xuatban', 1], ['phim_kieu', 'TV Series']])
                                          ->orWhere([['phim_xuatban', 1], ['phim_kieu', 'Ova']])
                                          ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                          ->orderByRaw('phim_ngaycapnhat_moinhat DESC')
                                          ->offset($offset)
                                          ->limit($limit)
                                          ->get();
        
                
        for($i = 0; $i < count($listPhimToday); $i++){
            $listPhimToday[$i]->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $listPhimToday[$i]->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }
        
        if(count($listPhimToday)>0){
            $html = '';
            foreach ($listPhimToday as $row){
                $idTheLoai = json_decode($row->theloai_id);
                $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
                if(count($row->tap)>0){
                    $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">';
                    $html .=    '<a title="'.$row->phim_ten.(strlen($row->phim_tenvn)>0?' | '.$row->phim_tenvn:'').'" class="click-loading" href="'.URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/?pid='.$row->phim_id.'&t='.$row->tap[0]->tap_tapso.'&s='.md5('google').'" data-toggle="modal" data-target="">';
                    $html .=        '<div class="box-phim">';
                    $html .=            '<div class="box-image">';
                    $html .=                '<img src="'.$row->phim_hinhnen.'" />';
                    $html .=            '</div>';
                    $html .=            '<div class="box-overlay-rich"></div>';
                    $html .=            '<div class="box-info">';
                    $html .=                '<div class="box-title">';                    
                    $html .=                    '<div>'.(strlen($row->phim_ten.' (SS'.$row->phim_season.')')>20?substr($row->phim_ten,0,20).'...':$row->phim_ten.' (SS'.$row->phim_season.')').'</div>';
                    $html .=                    '<div class="title-vn">'.(strlen($row->phim_tenvn)>28?substr($row->phim_tenvn,0,strrpos(substr($row->phim_tenvn,0,28),' ')).'...':$row->phim_tenvn).'</div>';
                    $html .=                '</div>';
                    $html .=                '<div class="box-text">'.$row->tap[0]->tap_tapso.'/'.$row->phim_sotap.'</div>';
//                    $html .=                '<div class="box-text">';
//                    $html .=                    '<span style="float:left;" class="view-str-'.$row->phim_id.'">'.self::demLuotXem($row->tap[0]->tap_luotxem).' lượt xem</span>';
//                    $html .=                    '<span style="float:right;">'.self::getStrSoNgayDaQua($row->tap[0]->tap_ngaycapnhat).'</span>';
//                    $html .=                '</div>';
                    $html .=            '</div>';                    
                    $html .=        '</div>';
                    $html .=        '<div class="phim-tip">';
                    $html .=            '<div class="phim-tip-content">';
                    $html .=                '<div class="phim-tip-ten">'.$row->phim_ten.'</div>';
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-time"></span>&nbsp;<span class="title">Season</span> '.$row->phim_season.' <span style="float:right"><span class="glyphicon glyphicon-calendar"></span>&nbsp;<span class="title">Năm</span> '.$row->phim_nam.'<span></div>';
                    if(is_null($row->phim_gioithieu)){
                        $html .=                '<div class="phim-tip-noidung">Đang cập nhật ...</div>';
                    } else {
                        $html .=                '<div class="phim-tip-noidung">'.(strlen($row->phim_gioithieu)>255?substr($row->phim_gioithieu,0,strrpos(substr($row->phim_gioithieu,0,255),' ')).' ...':$row->phim_gioithieu).'</div>';
                    }
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-tasks"></span>&nbsp;<span class="title">Thể loại:</span> ';
                                            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                                                $html .=  $listTheLoaiPhim[$i]->theloai_ten;
                                                $html .=  $i+1<count($listTheLoaiPhim)?', ':'.';
                                            }
                    $html .=                '</div>';                    
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-list"></span>&nbsp;<span class="title">Số tập:</span> '.$row->phim_sotap.'</div>';                    
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-expand"></span>&nbsp;<span class="title">Loại phim:</span> '.$row->phim_kieu.'</div>';
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-globe"></span>&nbsp;<span class="title">Quốc gia:</span> '.$row->quocgia_ten.'</div>';
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;<span class="title">Lượt xem:</span> '.number_format($row->phim_luotxem).'</div>';
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-star"></span>&nbsp;<span class="title">Đánh giá:</span> ';
                    $star = ClassCommon::getStar($row->phim_id); 
                    for($i = 1; $i <= 5; $i++){
                        if($i <= intval($star)){
                            $html .= '<span class="glyphicon fa fa-star star star-color"></span>';
                        } else if($i > $star && ($i-1) < $star){
                            $html .= '<span class="glyphicon fa fa-star-half-alt star star-half-color"></span>';
                        } else {
                            $html .= '<span class="fa fa-star star"></span>';
                        }
                    }        
                    $html .=                '</div>';
                    $html .=            '</div>';
                    $html .=        '</div>';
                    $html .=    '</a>';
                    $html .= '</div>';
                }
            }
            return $html;
        } else {
            return '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span><i style="color:gray">Không tìm thấy dữ liệu</i></span></div>';
        }        
    }

    public static function getHTMLMovieMoi($limit, $offset){
        
        $listPhim = DB::table('phim')->where([['phim_xuatban', 1], ['phim_kieu', 'Movie']])
                                          ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                          ->orderByRaw('phim_ngaycapnhat_moinhat DESC')
                                          ->offset($offset)
                                          ->limit($limit)
                                          ->get();
                  
        for($i = 0; $i < count($listPhim); $i++){
            $listPhim[$i]->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat, tap_luotxem')
                    ->where('phim_id', $listPhim[$i]->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }
        
        if(count($listPhim)>0){
            $html = '';
            foreach ($listPhim as $row){
                $idTheLoai = json_decode($row->theloai_id);
                $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
                if(count($row->tap)>0){
                    $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">';
                    $html .=    '<a title="'.$row->phim_ten.(strlen($row->phim_tenvn)>0?' | '.$row->phim_tenvn:'').'" class="click-loading" href="'.URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/?pid='.$row->phim_id.'&t='.$row->tap[0]->tap_tapso.'&s='.md5('google').'" data-toggle="modal" data-target="">';
                    $html .=        '<div class="box-phim">';
                    $html .=            '<div class="box-image">';
                    $html .=                '<img src="'.$row->phim_hinhnen.'" />';
                    $html .=            '</div>';
                    $html .=            '<div class="box-overlay-rich"></div>';
                    $html .=            '<div class="box-info">';
                    $html .=                '<div class="box-title">';                    
                    $html .=                    '<div>'.(strlen($row->phim_ten.' (SS'.$row->phim_season.')')>20?substr($row->phim_ten,0,20).'...':$row->phim_ten.' (SS'.$row->phim_season.')').'</div>';
                    $html .=                    '<div class="title-vn">'.(strlen($row->phim_tenvn)>28?substr($row->phim_tenvn,0,strrpos(substr($row->phim_tenvn,0,28),' ')).'...':$row->phim_tenvn).'</div>';
                    $html .=                '</div>';
                    $html .=                '<div class="box-text">'.$row->tap[0]->tap_tapsohienthi.'</div>';
                    $html .=            '</div>';                    
                    $html .=        '</div>';
                    $html .=        '<div class="phim-tip">';
                    $html .=            '<div class="phim-tip-content">';
                    $html .=                '<div class="phim-tip-ten">'.$row->phim_ten.'</div>';
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-time"></span>&nbsp;<span class="title">Season</span> '.$row->phim_season.' <span style="float:right"><span class="glyphicon glyphicon-calendar"></span>&nbsp;<span class="title">Năm</span> '.$row->phim_nam.'<span></div>';
                    if(is_null($row->phim_gioithieu)){
                        $html .=                '<div class="phim-tip-noidung">Đang cập nhật ...</div>';
                    } else {
                        $html .=                '<div class="phim-tip-noidung">'.(strlen($row->phim_gioithieu)>255?substr($row->phim_gioithieu,0,strrpos(substr($row->phim_gioithieu,0,255),' ')).' ...':$row->phim_gioithieu).'</div>';
                    }
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-tasks"></span>&nbsp;<span class="title">Thể loại:</span> ';
                                            for($i = 0; $i < count($listTheLoaiPhim); $i++){
                                                $html .=  $listTheLoaiPhim[$i]->theloai_ten;
                                                $html .=  $i+1<count($listTheLoaiPhim)?', ':'.';
                                            }
                    $html .=                '</div>';                    
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-list"></span>&nbsp;<span class="title">Số tập:</span> '.$row->phim_sotap.'</div>';                    
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-expand"></span>&nbsp;<span class="title">Loại phim:</span> '.$row->phim_kieu.'</div>';
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-globe"></span>&nbsp;<span class="title">Quốc gia:</span> '.$row->quocgia_ten.'</div>';
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;<span class="title">Lượt xem:</span> '.number_format($row->phim_luotxem).'</div>';
                    $html .=                '<div class="phim-tip-underten"><span class="glyphicon glyphicon-star"></span>&nbsp;<span class="title">Đánh giá:</span> ';
                    $star = ClassCommon::getStar($row->phim_id); 
                    for($i = 1; $i <= 5; $i++){
                        if($i <= intval($star)){
                            $html .= '<span class="glyphicon fa fa-star star star-color"></span>';
                        } else if($i > $star && ($i-1) < $star){
                            $html .= '<span class="glyphicon fa fa-star-half-alt star star-half-color"></span>';
                        } else {
                            $html .= '<span class="fa fa-star star"></span>';
                        }
                    }        
                    $html .=                '</div>';
                    $html .=            '</div>';
                    $html .=        '</div>';
                    $html .=    '</a>';
                    $html .= '</div>';
                }
            }
            return $html;
        } else {
            return '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span><i style="color:gray">Không tìm thấy dữ liệu</i></span></div>';
        }        
    }
    
    public static function getHTMLTheLoai($theloai, $limit, $offset){
        $listPhimTheLoai = DB::select(DB::raw('SELECT * FROM phim '
                . ' WHERE theloai_id like "%\"'.$theloai.'\"%" AND phim_xuatban = 1 '
                . ' ORDER BY phim.phim_luotxem DESC LIMIT '.$limit.' OFFSET '.$offset));            
        for($i = 0; $i < count($listPhimTheLoai); $i++){
            $listPhimTheLoai[$i]->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat')
                    ->where('phim_id', $listPhimTheLoai[$i]->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }
        
        if(count($listPhimTheLoai)>0){
            $html = '';
            foreach ($listPhimTheLoai as $row){
                if(count($row->tap)>0){
                    $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">';
                    $html .=    '<a class="click-loading" href="'.URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/?pid='.$row->phim_id.'&t=1&s='.md5('google').'" data-toggle="modal" data-target="">';
                    $html .=        '<div class="npv-box-phim">';
                    $html .=            '<div class="box-image">';
                    $html .=                '<img src="'.$row->phim_hinhnen.'" width="100%" height="100%" />';
                    $html .=            '</div>';
                    $html .=            '<div class="box-info">';
                    $html .=                '<div class="box-title">'.$row->phim_ten.'</div>';
                    $html .=                '<div class="box-text">'.$row->tap[0]->tap_tapsohienthi.'/'.$row->phim_sotap.'</div>';
                    $html .=                '<div class="box-text">';
                    $html .=                    '<span style="float:left;" class="view-str-'.$row->phim_id.'">'.self::demLuotXem($row->phim_luotxem).' lượt xem</span>';
                    $html .=                    '<span style="float:right;">'.self::getStrSoNgayDaQua($row->tap[0]->tap_ngaycapnhat).'</span>';
                    $html .=                '</div>';
                    $html .=            '</div>';
                    $html .=        '</div>';
                    $html .=    '</a>';
                    $html .= '</div>';
                }
            }
            return $html;
        } else {
            return '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span><i style="color:gray">Không tìm thấy dữ liệu</i></span></div>';
        }        
    }
    
    public static function getHTMLNam($nam, $limit, $offset){
        $listPhimNam = DB::select(DB::raw('SELECT * FROM phim '
                . ' WHERE phim_xuatban = 1 AND phim_nam = ' .$nam
                . ' ORDER BY phim.phim_luotxem DESC LIMIT '.$limit.' OFFSET '.$offset)); 
        for($i = 0; $i < count($listPhimNam); $i++){
            $listPhimNam[$i]->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat')
                    ->where('phim_id', $listPhimNam[$i]->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }
        
        if(count($listPhimNam)>0){
            $html = '';
            foreach ($listPhimNam as $row){
                if(count($row->tap)>0){
                    $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">';
                    $html .=    '<a class="click-loading" href="'.URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/?pid='.$row->phim_id.'&t=1&s='.md5('google').'" data-toggle="modal" data-target="">';
                    $html .=        '<div class="npv-box-phim">';
                    $html .=            '<div class="box-image">';
                    $html .=                '<img src="'.$row->phim_hinhnen.'" width="100%" height="100%" />';
                    $html .=            '</div>';
                    $html .=            '<div class="box-info">';
                    $html .=                '<div class="box-title">'.$row->phim_ten.'</div>';
                    $html .=                '<div class="box-text">'.$row->tap[0]->tap_tapsohienthi.'/'.$row->phim_sotap.'</div>';
                    $html .=                '<div class="box-text">';
                    $html .=                    '<span style="float:left;" class="view-str-'.$row->phim_id.'">'.self::demLuotXem($row->phim_luotxem).' lượt xem</span>';
                    $html .=                    '<span style="float:right;">'.self::getStrSoNgayDaQua($row->tap[0]->tap_ngaycapnhat).'</span>';
                    $html .=                '</div>';
                    $html .=            '</div>';
                    $html .=        '</div>';
                    $html .=    '</a>';
                    $html .= '</div>';
                }
            }
            return $html;
        } else {
            return '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span><i style="color:gray">Không tìm thấy dữ liệu</i></span></div>';
        }        
    }
    
    public static function getHTMLBangXepHang($time, $limit, $offset){
        if(strcmp($time, 'week') == 0){
            $listPhimXepHang = DB::select(DB::raw('SELECT phim_id, phim_hinhnen, phim_hinhanh,'
                . ' phim_ten, phim_sotap, phim_luotxem_tuan AS phim_luotxem, phim_tenvn FROM phim '                
                . ' WHERE phim_luotxem_tuan > 0 AND phim_xuatban = 1 '
                . ' ORDER BY phim.phim_luotxem_tuan DESC LIMIT '.$limit.' OFFSET '.$offset));
        } else if(strcmp($time, 'month') == 0){
            $listPhimXepHang = DB::select(DB::raw('SELECT phim_id, phim_hinhnen, phim_hinhanh,'
                . ' phim_ten, phim_sotap, phim_luotxem_thang AS phim_luotxem, phim_tenvn FROM phim '                
                . ' WHERE phim_luotxem_thang > 0 AND phim_xuatban = 1 '
                . ' ORDER BY phim.phim_luotxem_thang DESC LIMIT '.$limit.' OFFSET '.$offset));
        } else {
            $listPhimXepHang = DB::select(DB::raw('SELECT * FROM phim WHERE phim_xuatban = 1 '                
                . ' ORDER BY phim.phim_luotxem DESC LIMIT '.$limit.' OFFSET '.$offset));
        }         
        for($i = 0; $i < count($listPhimXepHang); $i++){
            $listPhimXepHang[$i]->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat')
                    ->where('phim_id', $listPhimXepHang[$i]->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }
        
        if(count($listPhimXepHang)>0){
            $rank = 1+$offset;
            $html = '';
            foreach ($listPhimXepHang as $row){
                if(count($row->tap)>0){
                    $star = ClassCommon::getStar($row->phim_id);
                    $html .= '<tr>';
                    $html .=    '<td data-title="Hạng" class="text-center npv-rank-number">#'.$rank.'</td>';
                    $html .=    '<td data-title="" class="npv-rank-td-image"><a class="click-loading npv-rank-name" href="'.URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/?pid='.$row->phim_id.'&t=1&s='.md5('google').'"><img class="npv-rank-image" src="'.$row->phim_hinhnen.'" /></a></td>';
                    $html .=    '<td data-title="Tên phim" class="text-left"><a class="click-loading npv-rank-name" href="'.URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/?pid='.$row->phim_id.'&t=1&s='.md5('google').'" data-toggle="tooltip" title="Xem phim">'.$row->phim_ten.'</a></td>';
                    if(strcmp($time, 'week') == 0){
                        $html .=    '<td data-title="Lượt xem" class="text-right npv-rank-view view-week-'.$row->phim_id.'">'. self::formatLuotXem($row->phim_luotxem).' lượt xem</td>';
                    } else if(strcmp($time, 'month') == 0){
                        $html .=    '<td data-title="Lượt xem" class="text-right npv-rank-view view-month-'.$row->phim_id.'">'. self::formatLuotXem($row->phim_luotxem).' lượt xem</td>';
                    } else {
                        $html .=    '<td data-title="Lượt xem" class="text-right npv-rank-view view-'.$row->phim_id.'">'. self::formatLuotXem($row->phim_luotxem).' lượt xem</td>';
                    }                    
                    $html .=    '<td data-title="Đánh giá" class="text-center npv-rank-danhgia">';
                    for($i = 1; $i <= 5; $i++){
                        if($i <= intval($star)){
                            $html .= '<span class="fa fa-star star star-color"></span>';
                        } else if($i > $star && ($i-1) < $star){
                            $html .= '<span class="fa fa-star-half-full star star-half-color"></span>';
                        } else {
                            $html .= '<span class="fa fa-star-o star"></span>';
                        }
                    }
                    $html .=    '</td>';
                    $html .= '</tr>';
                    $rank++;
                }
            }
            return $html;
        } else {
            return '<tr><td colspan="5" class="text-center"><i style="color:gray">Không tìm thấy dữ liệu</i></td></tr>';
        }        
    }
    public static function getBangXepHang($time, $limit, $offset){
        if(strcmp($time, 'week') == 0){
            $listPhim = DB::select(DB::raw('SELECT phim_id, phim_hinhnen, phim_hinhanh,'
                . ' phim_ten, phim_sotap, phim_luotxem_tuan AS phim_luotxem, phim_tenvn FROM phim '                
                . ' WHERE phim_luotxem_tuan > 0 AND phim_xuatban = 1 '
                . ' ORDER BY phim.phim_luotxem_tuan DESC LIMIT '.$limit.' OFFSET '.$offset));
        } else if(strcmp($time, 'month') == 0){
            $listPhim = DB::select(DB::raw('SELECT phim_id, phim_hinhnen, phim_hinhanh,'
                . ' phim_ten, phim_sotap, phim_luotxem_thang AS phim_luotxem, phim_tenvn FROM phim '                
                . ' WHERE phim_luotxem_thang > 0 AND phim_xuatban = 1 '
                . ' ORDER BY phim.phim_luotxem_thang DESC LIMIT '.$limit.' OFFSET '.$offset));
        } else {
            $listPhim = DB::select(DB::raw('SELECT * FROM phim WHERE phim_xuatban = 1 '                
                . ' ORDER BY phim.phim_luotxem DESC LIMIT '.$limit.' OFFSET '.$offset));
        }
        
        $view = 0;
        for($i = 0; $i < count($listPhim); $i++){
            $listPhim[$i]->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat')
                    ->where('phim_id', $listPhim[$i]->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
            if($listPhim[$i]->phim_luotxem == $view){
                $phim_idX = $listPhim[$i-1]->phim_id;
                $phim_idY = $listPhim[$i]->phim_id;
                $starX = DB::table('danhgia')->where('phim_id', $phim_idX)->avg('danhgia_star');
                $starY = DB::table('danhgia')->where('phim_id', $phim_idY)->avg('danhgia_star');
                if($starY > $starX){
                    $temp = $listPhim[$i];
                    $listPhim[$i] = $listPhim[$i-1];
                    $listPhim[$i-1] = $temp;
                }
            }else{
                $view = $listPhim[$i]->phim_luotxem;
            }
        }
        return $listPhim;
    }
    
    public static function getHTMLTimKiem($tukhoa){
        $listResult = DB::table('phim')->where([['phim_ten', 'like', '%'.$tukhoa.'%'], ['phim_xuatban', '=', 1]])
                ->orwhere([['phim_tenkhac', 'like', '%'.$tukhoa.'%'], ['phim_xuatban', '=', 1]])
                ->orwhere([['phim_tenvn', 'like', '%'.$tukhoa.'%'], ['phim_xuatban', '=', 1]])
                ->limit(20)->get();
        $html = '<ul class="list-anime">';
        if(count($listResult) > 0){
            foreach ($listResult as $row){
                $html .= '<a href="'.(URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/?pid='.$row->phim_id.'&t=1&s='.md5('google')).'"><li>';
                $html .=    '<div style="float:left;">';
                $html .=        '<img src="'.$row->phim_hinhnen.'" width="60" height="70" style="border-radius:3px;" />';
                $html .=    '</div>';
                $html .=    '<div style="float:left;padding-left:10px;" >';
                $html .=        '<div><b>'.(strlen($row->phim_ten)>24?substr($row->phim_ten,0,24).'...':$row->phim_ten).'</b></div>';
                if(strlen($row->phim_tenvn)>0){
                    $html .=        '<div class="title-vn">'.(strlen($row->phim_tenvn)>28?'('.substr($row->phim_tenvn,0,strrpos(substr($row->phim_tenvn,0,28),' ')).'...':'('.$row->phim_tenvn.')').'</div>';
                }                
                $html .=        '<div>Season '.$row->phim_season.'</div>';
                $html .=        '<div>';
                                    $star = ClassCommon::getStar($row->phim_id); 
                                    for($i = 1; $i <= 5; $i++){
                                        if($i <= intval($star)){
                                            $html .= '<span class="fa fa-star star star-color"></span>';
                                        } else if($i > $star && ($i-1) < $star){
                                            $html .= '<span class="fa fa-star-half-alt star star-half-color"></span>';
                                        } else {
                                            $html .= '<span class="fa fa-star star"></span>';
                                        }
                                    }                         
                $html .=        '</div>';
                $html .=    '</div>';
                $html .= '</li></a>';
            }
        }else{
            $html .= '<a href="javascript:void(0)" style="text-decoration: none;"><li class="text-center" style="height:30px"><p style="font-size:0.8em">Không tìm thấy kết quả</p></li></a>';
        }
        $html .= '</ul>';
        return $html;
    }
                     
    public static function resetView(){
        self::resetViewTuan();
        self::resetViewThang();
    }
    
    public static function resetViewTuan(){
        $result = 0;
        if(date('W') == 1){
            $exist = DB::table('thongke_luotxem_tuan')->where([
                ['tuan',42],
                ['nam',date('Y')-1]
            ])->exists();
            if($exist != 1){
                $result = DB::insert(DB::raw('INSERT INTO thongke_luotxem_tuan(tuan, nam, phim_id, phim_luotxem_tuan, ngaycapnhat)'
                        . ' SELECT 42, '.(date('Y')-1).',phim_id, phim_luotxem_tuan, "'.now().'" FROM phim'));
            }
        } else {
            $exist = DB::table('thongke_luotxem_tuan')->where([
                ['tuan',(date('W')-1)],
                ['nam',date('Y')]
            ])->exists();
            if($exist != 1){
                $result = DB::insert(DB::raw('INSERT INTO thongke_luotxem_tuan(tuan, nam, phim_id, phim_luotxem_tuan, ngaycapnhat)'
                        . ' SELECT '.(date('W')-1).', '.date('Y').',phim_id, phim_luotxem_tuan, "'.now().'" FROM phim'));                
            }
        }
        if($result == 1){
            DB::table('phim')->update(
                ['phim_luotxem_tuan' => 0]
            );
        }
    }
    
    public static function resetViewThang(){
        $result = 0;
        if(date('m') == 1){
            $exist = DB::table('thongke_luotxem_thang')->where([
                ['thang',12],
                ['nam',date('Y')-1]
            ])->exists();
            if($exist != 1){
                $result = DB::insert(DB::raw('INSERT INTO thongke_luotxem_thang(thang, nam, phim_id, phim_luotxem_thang, ngaycapnhat)'
                        . ' SELECT 12, '.(date('Y')-1).',phim_id, phim_luotxem_thang, "'.now().'" FROM phim'));
            }
        } else {
            $exist = DB::table('thongke_luotxem_thang')->where([
                ['thang',(date('m')-1)],
                ['nam',date('Y')]
            ])->exists();
            if($exist != 1){
                $result = DB::insert(DB::raw('INSERT INTO thongke_luotxem_thang(thang, nam, phim_id, phim_luotxem_thang, ngaycapnhat)'
                        . ' SELECT '.(date('m')-1).', '.date('Y').',phim_id, phim_luotxem_thang, "'.now().'" FROM phim'));                
            }
        }
        if($result == 1){
            DB::table('phim')->update(
                ['phim_luotxem_thang' => 0]
            );
        }
    }
    
    public static function sendPusher($phim_id, $tapso) {
        $phim = DB::table('phim')->where('phim_id', $phim_id)->get();
        $tap = DB::table('tap')->where([['tap_tapso', $tapso],['phim_id', $phim_id]])->get();
        $data['event'] = 'pnew';
        $array['icon'] = $phim[0]->phim_hinhanh;
        $array['tenphim'] = $phim[0]->phim_ten;
        $array['tap'] = 'Tập '.$tap[0]->tap_tapsohienthi;
        $array['tentap'] = strcmp($tap[0]->tap_ten, '')==0?null:$tap[0]->tap_ten;
        $array['link'] = URL::to('/xem-phim') . '/' . strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten)))) . '/?pid=' . $phim_id . '&t=' . $tapso . '&s='.md5('google');
        $data['content'] = $array;
        event(new PusherEvent($data));
    }

    public static function getStar($phim_id) {
        $danhGia = DB::table('danhgia')->selectRaw('SUM(danhgia_star) as sumStar, count(1) as countLuot')->where('phim_id', $phim_id)->get();
        if($danhGia[0]->sumStar > 0){
            $star = $danhGia[0]->sumStar / $danhGia[0]->countLuot;
            if (strlen($star) > 1) {
                if (intval(substr($star, 2)) == 5) {
                    $star = intval($star) + 0.5;
                } else if (intval(substr($star, 2)) > 50) {
                    $star = intval($star) + 1;
                } else {
                    $star = $star - 0.25;
                }
            }    
            return $star;
        } else {
            return 4;
        }        
    }

    public static function getVoteTimes($phim_id) {
        return DB::table('danhgia')->where('phim_id', $phim_id)->count();           
    }

    public static function countUser(){
        return DB::table('users')->count();
    }

    public static function countPhim(){
        return DB::table('phim')->count();
    }

    public static function countReportError(){
        return DB::table('error_report')->count();
    }

    public static function countYeuCauPhim(){
        return DB::table('yeucau')->count();
    }
    
    public static function randomAvatar(){
        $avatarid = rand(1, 4);
        $newName=time();
        $path = 'upload/avatar/'.$newName.'_user.png';
        copy('img/themes/avatar/user-10'.$avatarid.'.png', $path);
        return $path;
    }
    
    public static function removeVietnamese($str){
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }       
        return $str;
    }
}
