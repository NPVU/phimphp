<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class ClassCommon extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public static function nullOrEmptyString($str){
        return (!isset($str) || trim($str) === '');
    }
    
    public static function getPathUploadAvatar(){
        return 'public/upload/avatar/';
    }
    
    public static function getPathUploadImage(){
        return 'public/upload/image/';
    }
    
    public static function getPathUploadTemp(){
        return 'public/upload/temp/';
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
    
    public static function getHTMLTapMoi($limit, $offset){
        $listPhimToday = DB::select(DB::raw('SELECT * FROM phim '
                . ' JOIN (SELECT DISTINCT phim_id FROM tap ORDER BY tap_ngaycapnhat DESC LIMIT '.$limit.' OFFSET '.$offset.') tap '
                . ' ON phim.phim_id IN (tap.phim_id) ORDER BY phim.phim_id DESC'));            
        for($i = 0; $i < count($listPhimToday); $i++){
            $listPhimToday[$i]->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat')
                    ->where('phim_id', $listPhimToday[$i]->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }
        
        if(count($listPhimToday)>0){
            $html = '';
            foreach ($listPhimToday as $row){
                if(count($row->tap)>0){
                    $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">';
                    $html .=    '<a class="click-loading" href="'.URL::to('/xem-phim').'/'.strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten))).'/?pid='.$row->phim_id.'&t='.$row->tap[0]->tap_tapso.'&s='.md5('google').'&token='.Session::token().'" data-toggle="modal" data-target="">';
                    $html .=        '<div class="npv-box-phim">';
                    $html .=            '<div class="box-image">';
                    $html .=                '<img src="'.$row->phim_hinhnen.'" width="100%" height="100%" />';
                    $html .=            '</div>';
                    $html .=            '<div class="box-info">';
                    $html .=                '<div class="box-title">'.$row->phim_ten.'</div>';
                    $html .=                '<div class="box-text">'.$row->tap[0]->tap_tapsohienthi.'</div>';
                    $html .=                '<div class="box-text">';
                    $html .=                    '<span style="float:left;">'.self::demLuotXem($row->phim_luotxem).' lượt xem</span>';
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
    
    public static function getHTMLTheLoai($theloai, $limit, $offset){
        $listPhimTheLoai = DB::select(DB::raw('SELECT * FROM phim '
                . ' WHERE theloai_id like "%\"'.$theloai.'\"%" '
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
                    $html .=    '<a class="click-loading" href="'.URL::to('/xem-phim').'/'.strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten))).'/?pid='.$row->phim_id.'&t=1&s='.md5('google').'&token='.Session::token().'" data-toggle="modal" data-target="">';
                    $html .=        '<div class="npv-box-phim">';
                    $html .=            '<div class="box-image">';
                    $html .=                '<img src="'.$row->phim_hinhnen.'" width="100%" height="100%" />';
                    $html .=            '</div>';
                    $html .=            '<div class="box-info">';
                    $html .=                '<div class="box-title">'.$row->phim_ten.'</div>';
                    $html .=                '<div class="box-text">'.$row->tap[0]->tap_tapsohienthi.'/'.$row->phim_sotap.'</div>';
                    $html .=                '<div class="box-text">';
                    $html .=                    '<span style="float:left;">'.self::demLuotXem($row->phim_luotxem).' lượt xem</span>';
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
                . ' WHERE phim_nam = ' .$nam
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
                    $html .=    '<a class="click-loading" href="'.URL::to('/xem-phim').'/'.strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten))).'/?pid='.$row->phim_id.'&t=1&s='.md5('google').'&token='.Session::token().'" data-toggle="modal" data-target="">';
                    $html .=        '<div class="npv-box-phim">';
                    $html .=            '<div class="box-image">';
                    $html .=                '<img src="'.$row->phim_hinhnen.'" width="100%" height="100%" />';
                    $html .=            '</div>';
                    $html .=            '<div class="box-info">';
                    $html .=                '<div class="box-title">'.$row->phim_ten.'</div>';
                    $html .=                '<div class="box-text">'.$row->tap[0]->tap_tapsohienthi.'/'.$row->phim_sotap.'</div>';
                    $html .=                '<div class="box-text">';
                    $html .=                    '<span style="float:left;">'.self::demLuotXem($row->phim_luotxem).' lượt xem</span>';
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
            $listPhimXemHang = DB::select(DB::raw('SELECT phim_id, phim_hinhnen, phim_hinhanh,'
                . ' phim_ten, phim_sotap, phim_luotxem_tuan AS phim_luotxem FROM phim '                
                . ' WHERE phim_luotxem_tuan > 0 '
                . ' ORDER BY phim.phim_luotxem_tuan DESC LIMIT '.$limit.' OFFSET '.$offset));
        } else if(strcmp($time, 'month') == 0){
            $listPhimXemHang = DB::select(DB::raw('SELECT phim_id, phim_hinhnen, phim_hinhanh,'
                . ' phim_ten, phim_sotap, phim_luotxem_thang AS phim_luotxem FROM phim '                
                . ' WHERE phim_luotxem_thang > 0 '
                . 'ORDER BY phim.phim_luotxem_thang DESC LIMIT '.$limit.' OFFSET '.$offset));
        } else {
            $listPhimXemHang = DB::select(DB::raw('SELECT * FROM phim '                
                . ' ORDER BY phim.phim_luotxem DESC LIMIT '.$limit.' OFFSET '.$offset));
        }         
        for($i = 0; $i < count($listPhimXemHang); $i++){
            $listPhimXemHang[$i]->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi, tap_ngaycapnhat')
                    ->where('phim_id', $listPhimXemHang[$i]->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }
        
        if(count($listPhimXemHang)>0){
            $rank = 1+$offset;
            $html = '';
            foreach ($listPhimXemHang as $row){
                if(count($row->tap)>0){
                    $html .= '<tr>';
                    $html .=    '<td data-title="Hạng" class="text-center npv-rank-number" style="width:10%">#'.$rank.'</td>';
                    $html .=    '<td data-title="" class="npv-rank-td-image" style="width:15%"><img class="npv-rank-image" src="'.$row->phim_hinhnen.'" /></td>';
                    $html .=    '<td data-title="Tên phim" class="text-left"><a class="click-loading npv-rank-name" href="'.URL::to('/xem-phim').'/'.strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten))).'/?pid='.$row->phim_id.'&t=1&s='.md5('google').'&token='.Session::token().'" data-toggle="tooltip" title="Xem phim">'.$row->phim_ten.'</a></td>';
                    $html .=    '<td data-title="Lượt xem" class="text-right npv-rank-view" style="width:15%">'.$row->phim_luotxem.'</td>';
                    $html .=    '<td data-title="Đánh giá" class="text-center npv-rank-danhgia" style="width:20%">dang cap nhat</td>';
                    $html .= '</tr>';
                    $rank++;
                }
            }
            return $html;
        } else {
            return '<tr><td colspan="5" class="text-center"><i style="color:gray">Không tìm thấy dữ liệu</i></td></tr>';
        }        
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
