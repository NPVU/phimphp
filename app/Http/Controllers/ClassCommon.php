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
        $view = rand(1, 5);
        DB::table('tap')->where([
                        ['phim_id', $phimID],
                        ['tap_id', $tap]
                    ])->update([
                        'tap_luotxem' => DB::raw('tap_luotxem + '.$view)
                    ]);        
        self::updateLuotXem($phimID, $view);
    }
    
    public static function updateLuotXem($phimID, $view){
        DB::table('phim')->where('phim_id', $phimID)->update([
            'phim_luotxem'  => DB::raw('(SELECT SUM(tap_luotxem) FROM tap WHERE tap.phim_id = '.$phimID.')'),
            'phim_luotxem_tuan'  => DB::raw('(SELECT phim_luotxem_tuan + '.$view.' )'),
            'phim_luotxem_thang'  => DB::raw('(SELECT phim_luotxem_thang + '.$view.' )')
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
        $listPhimToday = DB::table('phim')->where([['phim_xuatban', 1], ['phim_kieu', 1]])
                                          ->orWhere([['phim_xuatban', 1], ['phim_kieu', 3]])
                                          ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                          ->join('loaiphim', 'loaiphim.loaiphim_id', '=', 'phim.phim_kieu')
                                          ->orderByRaw('phim_ngaycapnhat_moinhat DESC')
                                          ->offset($offset)
                                          ->limit($limit)
                                          ->get();                                        
       
            $html = '';
            foreach ($listPhimToday as $row){
                $idTheLoai = json_decode($row->theloai_id);
                $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();               
                    $html .= '<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">';
                    $html .=    '<a data-template="phim-'.$row->phim_id.'" class="click-loading ttip" href="/xem-phim/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/'.$row->max_tap_id.'.html">';
                    $html .=        '<div class="box-phim">';
                    $html .=            '<div class="box-image">';
                    $html .=                '<img class="lazy" src="'.($row->phim_thumb!=null? $row->phim_thumb:$row->phim_hinhnen).'" />';
                    $html .=            '</div>';
                    $html .=            '<div class="box-overlay-rich"></div>';
                    $html .=            '<div class="box-info">';
                    $html .=                '<div class="box-title">';                    
                    $html .=                    '<div>'.$row->phim_ten.'</div>';
                    $html .=                    '<div class="title-vn">'.$row->phim_tenvn.'</div>';
                    $html .=                '</div>';
                    $html .=                '<div class="box-text">'.$row->phim_taphienthi.'/'.$row->phim_sotap.'</div>';
//                    $html .=                '<div class="box-text">';
//                    $html .=                    '<span style="float:left;" class="view-str-'.$row->phim_id.'">'.self::demLuotXem($row->tap[0]->tap_luotxem).' lượt xem</span>';
//                    $html .=                    '<span style="float:right;">'.self::getStrSoNgayDaQua($row->tap[0]->tap_ngaycapnhat).'</span>';
//                    $html .=                '</div>';
                    $html .=            '</div>';                    
                    $html .=        '</div>';
                    
                    
                    $html .=        '<div id="phim-'.$row->phim_id.'">';
                    $html .=            '<div class="phim-tip-content display-none">';
                    $html .=                '<div class="tip ten-phim ten-phim-chinh">'.$row->phim_ten.'</div>';
                    $html .=                '<div class="tip ten-phim ten-phim-phu">'.$row->phim_tenkhac.'</div>';
                    $html .=                '<div class="tip ten-phim ten-phim-tieng-viet">'.$row->phim_tenvn.'</div>';
                    $html .=                '<div class="tip the-loai" style="margin-top:10px;"><span class="tip-title">Thể loại:</span> ';
                                                for($i = 0; $i < count($listTheLoaiPhim); $i++){
                                                    $html .=  $listTheLoaiPhim[$i]->theloai_ten;
                                                    $html .=  $i+1<count($listTheLoaiPhim)?', ':'.';
                                                }
                    $html .=                '</div>';      
                    $html .=                '<div class="tip so-tap"><span class="tip-title">Số tập:</span> '.$row->phim_sotap.'</div>'; 
                    $html .=                '<div class="tip nam"><span class="tip-title">Năm:</span> '.$row->phim_nam.'</div>';                                  
                    $html .=                '<div class="tip luot-xem"><span class="tip-title">Tổng lượt xem:</span> '.number_format($row->phim_luotxem).'</div>';
                    $html .=                '<div class="tip noi-dung">'.$row->phim_gioithieu.'</div> ';
                    $html .=            '</div>';
                    $html .=        '</div>';
                    
                    
                    $html .=    '</a>';
                    $html .= '</div>';                
            }
            return $html;
           
    }

    public static function getHTMLMovieMoi($limit, $offset){
        
        $listPhim = DB::table('phim')->where([['phim_xuatban', 1], ['phim_kieu', 2]])
                                          ->orwhere([['phim_xuatban', 1], ['phim_kieu', 4]])
                                          ->join('quocgia', 'quocgia.quocgia_id', '=', 'phim.quocgia_id')
                                          ->join('loaiphim', 'loaiphim.loaiphim_id', '=', 'phim.phim_kieu')
                                          ->orderByRaw('phim_ngaycapnhat_moinhat DESC')
                                          ->offset($offset)
                                          ->limit($limit)
                                          ->get();
                         
        if(count($listPhim)>0){
            $html = '';
            foreach ($listPhim as $row){
                $idTheLoai = json_decode($row->theloai_id);
                $listTheLoaiPhim = DB::table('theloai')->whereIn('theloai_id', $idTheLoai)->get();
                
                    $html .= '<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">';
                    $html .=    '<a data-template="phim-'.$row->phim_id.'" class="click-loading ttip" href="/xem-phim/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/'.$row->max_tap_id.'.html" data-toggle="modal" data-target="">';
                    $html .=        '<div class="box-phim">';
                    $html .=            '<div class="box-image">';
                    $html .=                '<img class="lazy" src="'.($row->phim_thumb!=null? $row->phim_thumb:$row->phim_hinhnen).'" />';
                    $html .=            '</div>';
                    $html .=            '<div class="box-overlay-rich"></div>';
                    $html .=            '<div class="box-info">';
                    $html .=                '<div class="box-title">';                    
                    $html .=                    '<div>'.$row->phim_ten.'</div>';
                    $html .=                    '<div class="title-vn">'.$row->phim_tenvn.'</div>';
                    $html .=                '</div>';
                    $html .=                '<div class="box-text">'.$row->phim_taphienthi.'</div>';
                    $html .=            '</div>';                    
                    $html .=        '</div>';
                    
                    $html .=        '<div id="phim-'.$row->phim_id.'">';
                    $html .=            '<div class="phim-tip-content display-none">';
                    $html .=                '<div class="tip ten-phim ten-phim-chinh">'.$row->phim_ten.'</div>';
                    $html .=                '<div class="tip ten-phim ten-phim-phu">'.$row->phim_tenkhac.'</div>';
                    $html .=                '<div class="tip ten-phim ten-phim-tieng-viet">'.$row->phim_tenvn.'</div>';
                    $html .=                '<div class="tip the-loai" style="margin-top:10px;"><span class="tip-title">Thể loại:</span> ';
                                                for($i = 0; $i < count($listTheLoaiPhim); $i++){
                                                    $html .=  $listTheLoaiPhim[$i]->theloai_ten;
                                                    $html .=  $i+1<count($listTheLoaiPhim)?', ':'.';
                                                }
                    $html .=                '</div>';      
                    $html .=                '<div class="tip so-tap"><span class="tip-title">Số tập:</span> '.$row->phim_sotap.'</div>'; 
                    $html .=                '<div class="tip nam"><span class="tip-title">Năm:</span> '.$row->phim_nam.'</div>';                                  
                    $html .=                '<div class="tip luot-xem"><span class="tip-title">Tổng lượt xem:</span> '.number_format($row->phim_luotxem).'</div>';
                    $html .=                '<div class="tip noi-dung">'.$row->phim_gioithieu.'</div> ';
                    $html .=            '</div>';
                    $html .=        '</div>';
                    
                    $html .=    '</a>';
                    $html .= '</div>';                
            }
            return $html;
        } else {
            return '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span><i style="color:gray">Không tìm thấy dữ liệu</i></span></div>';
        }        
    }
        
    public static function getBangXepHang($time, $limit, $offset){
        if(strcmp($time, 'week') == 0){
            $listPhim = DB::select(DB::raw('SELECT phim_id, phim_hinhnen, phim_hinhanh, phim_thumb,'
                . ' phim_ten, phim_sotap, phim_luotxem_tuan AS phim_luotxem, phim_tenvn, min_tap_id AS tap_id'
                . ' FROM phim '                
                . ' WHERE phim_luotxem_tuan > 0 AND phim_xuatban = 1 '
                . ' ORDER BY phim.phim_luotxem_tuan DESC LIMIT '.$limit.' OFFSET '.$offset));
        } else if(strcmp($time, 'month') == 0){
            $listPhim = DB::select(DB::raw('SELECT phim_id, phim_hinhnen, phim_hinhanh, phim_thumb, '
                . ' phim_ten, phim_sotap, phim_luotxem_thang AS phim_luotxem, phim_tenvn, min_tap_id AS tap_id'
                . ' FROM phim '                
                . ' WHERE phim_luotxem_thang > 0 AND phim_xuatban = 1 '
                . ' ORDER BY phim.phim_luotxem_thang DESC LIMIT '.$limit.' OFFSET '.$offset));
        } else {
            $listPhim = DB::select(DB::raw('(SELECT *, min_tap_id AS tap_id FROM phim WHERE phim_xuatban = 1 '                
                . ' ORDER BY phim.phim_luotxem DESC LIMIT '.$limit.' OFFSET '.$offset .')'));
        }
        
        /*$view = 0;
        for($i = 0; $i < count($listPhim); $i++){           
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
        }*/
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
                $tap = DB::table('tap')->where('phim_id',$row->phim_id)->orderByRaw('tap_tapso ASC')->limit(1)->get();
                $html .= '<a href="/xem-phim/'.(strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/'.$tap[0]->tap_id.'.html').'"><li>';
                $html .=    '<div style="float:left;">';
                $html .=        '<img class="lazy" src="'.$row->phim_hinhnen.'" style="border-radius:3px;" />';
                $html .=    '</div>';
                $html .=    '<div style="float:left;padding-left:10px;" >';
                $html .=        '<div class="title"><b>'.$row->phim_ten.'</b></div>';
                if(strlen($row->phim_tenvn)>0){
                    $html .=        '<div class="title title-vn">'.$row->phim_tenvn.'</div>';
                }                
                $html .=        '<div>Season '.$row->phim_season.' (Tập '.$row->phim_taphienthi.')</div>';
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
        $array['link'] = URL::to('/xem-phim') . '/' . strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten)))) . '/' . $tap[0]->tap_id . '.html';
        $data['content'] = $array;
        event(new PusherEvent($data));
    }

    public static function getStar($phim_id) {
        $danhGia = DB::table('danhgia')->selectRaw('AVG(danhgia_star) as star, count(1) as countLuot')->where('phim_id', $phim_id)->get();
        if($danhGia[0]->star > 0){            
            $star = $danhGia[0]->star;
            if (strlen($star) > 1) {
                if ((intval(substr($star, 2,1))*0.1 > 0.25) && intval(substr($star, 2,1))*0.1 < 0.75) {
                    $star = intval($star) + 0.5;
                } else {
                    $star = round($star);
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

    public static function formatSeconds( $seconds ){
        $hours = 0;
        $milliseconds = str_replace( "0.", '', $seconds - floor( $seconds ) );

        if ( $seconds > 3600 )
        {
            $hours = floor( $seconds / 3600 );
        }
        $seconds = $seconds % 3600;


        return str_pad( $hours, 2, '0', STR_PAD_LEFT )
            . gmdate( ':i:s', $seconds )
        ;
    }


    public static function isFirstEpisode($tap_id){
        $tap = DB::table('tap')->where('tap_id', $tap_id)->get();
        $minEp = DB::table('tap')->where('phim_id', $tap[0]->phim_id)->min('tap_tapso');
        if($tap[0]->tap_tapso == $minEp){
            return true;
        }else{
            return false;
        }
    }

    public static function isLastEpisode($tap_id){
        $tap = DB::table('tap')->where('tap_id', $tap_id)->get();
        $maxEp = DB::table('tap')->where('phim_id', $tap[0]->phim_id)->max('tap_tapso');
        if($tap[0]->tap_tapso == $maxEp){
            return true;
        }else{
            return false;
        }
    }

    public static function getNextEpisode($tap_id){
        $tap = DB::table('tap')->where('tap_id', $tap_id)->get();
        $next = DB::table('tap')->where([['phim_id', $tap[0]->phim_id],['tap_tapso', '>', $tap[0]->tap_tapso]])
                                ->orderByRaw('tap_tapso ASC')->limit(1)->get();        
        if(count($next) > 0){
            return $next[0]->tap_id;
        }
        return $tap_id;
    }

    public static function getPreviousEpisode($tap_id){
        $tap = DB::table('tap')->where('tap_id', $tap_id)->get();
        $previous = DB::table('tap')->where([['phim_id', $tap[0]->phim_id],['tap_tapso', '<', $tap[0]->tap_tapso]])
                                ->orderByRaw('tap_tapso DESC')->limit(1)->get();
        if(count($previous) > 0){
            return $previous[0]->tap_id;
        }
        return $tap_id;
    }
    
    public static function processAccess(){
        $ipaddress = DB::table('access')->where('access_ipaddress', request()->ip())->get();
        if(count($ipaddress) > 0){
            DB::table('access')->where('access_ipaddress', request()->ip())->update([                
                'access_url' => request()->fullUrl(),
                'access_times' => ($ipaddress[0]->access_times + 1),
                'access_time' => now()
            ]);
        }else{
            DB::table('access')->insert([
                'access_ipaddress' => request()->ip(),
                'access_url' => request()->fullUrl(),
                'access_time' => now()
            ]);
        } 
    }
}
