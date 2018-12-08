<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as Controller;

class PhimController extends Controller{
       
    public function __construct()
    {
        $this->middleware('auth');        
    }
    function hasRole(){
        $user = Auth::user();
        $hasRole = DB::table('users_roles')->whereRaw('user_id = '.$user->id.' AND (role_code = '.RoleUtils::getRoleSuperAdmin().' OR role_code = '.RoleUtils::getRoleAdminPhim().')')->count();
        return $hasRole>0?true:false;
    }
    
    public function index(Request $request){                
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
        
        $tenPhim = is_null($request->tenphim)?'':$request->tenphim;
        $tienDo = is_null($request->tiendo)?0:$request->tiendo; // mặc định chưa hoàn thành
        $xuatBan = is_null($request->trangthai)?-1:$request->trangthai; // mặc định đã xuất bản
        
        $where = ' 1 = 1 ';
        if($xuatBan != -1){
            $where .= ' AND phim_xuatban = ' . $xuatBan;
        }
        if ($tienDo != -1) {
            if ($tienDo == 1) {
                $where .= ' AND phim_hoanthanh = 1';
            } else {
                $where .= ' AND phim_hoanthanh = 0';
            }
        }
        if (!is_null($request->tenphim)) {
            $where .= ' AND (phim_ten like "%' . $request->tenphim . '%" OR phim_tenkhac like "%' . $request->tenphim . '%" )';
        }
        
        $count = DB::table('phim')
                ->whereRaw($where)
                ->count();

        $listPhim = DB::table('phim')
                ->selectRaw('phim.*, (SELECT COUNT(1) FROM tap AS tap where tap.phim_id = phim.phim_id) as tap,'
                        . '(SELECT MAX(tap.tap_tapso) FROM tap AS tap where tap.phim_id = phim.phim_id) as maxtap')
                ->whereRaw($where)->orderByRaw('phim_ten ASC')
                ->paginate(50);
        $listPhim->appends(['tenphim' => $request->$tenPhim, 'tiendo' => $tienDo, 'trangthai' => $xuatBan]);


        $data['listPhim'] = $listPhim;
        $data['count'] = $count;        
        $data['title'] = 'Quản Lý Phim';
        $data['page'] = 'admin.phim.index';
        return view('admin/layout', $data);
    }
    
    public function add(){
        session(['backURLAdmin' => url()->previous()]);
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
        $listTheLoai = DB::table('theloai')->orderByRaw('theloai_ten')->get();
        $data['listTheLoai'] = $listTheLoai;

        $listQuocGia = DB::table('quocgia')->get();
        $data['listQuocGia'] = $listQuocGia;
        
        $listLoaiPhim = DB::table('loaiphim')->get();
        $data['listLoaiPhim'] = $listLoaiPhim;
        
        $data['title'] = 'Thêm Phim';
        $data['page'] = 'admin.phim.add';        
        return view('admin/layout', $data);
    }
    
    public function edit($phim_id, $token){
        session(['backURLAdmin' => url()->previous()]);
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
        if(strcmp(Session::token(), $token) == 0){
            $phim = DB::table('phim')->where('phim_id', $phim_id)->get();
            $listTheLoai = DB::table('theloai')->orderByRaw('theloai_ten')->get();
            session(['phim_hinhanh' => $phim[0]->phim_hinhanh]); 
            session(['phim_hinhnen' => $phim[0]->phim_hinhnen]); 
            $listQuocGia = DB::table('quocgia')->get();
            $data['listQuocGia'] = $listQuocGia;
            $data['phim'] = $phim;
            $data['listTheLoai'] = $listTheLoai;
            
            $listLoaiPhim = DB::table('loaiphim')->get();
            $data['listLoaiPhim'] = $listLoaiPhim;
            
            $data['token'] = $token;

            $data['title'] = 'Chỉnh Sửa Phim';
            $data['page'] = 'admin.phim.edit';        
            return view('admin/layout', $data);
        } else {
            $data['title'] = 'Không tìm thấy trang';
            $data['page'] = 'errors.404';
            $data['backURL'] = URL::to('/quan-ly/phim');
            return view('errors/index', $data);            
        }
    }
    
    public function listTap($phim_id, $token){
        session(['backURLAdmin' => url()->previous()]);
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
        if(strcmp(Session::token(), $token) == 0){
            $list = DB::table('tap')->where('phim_id', $phim_id)->orderBy('tap_tapso')->get();
            $phim = DB::table('phim')->where('phim_id', $phim_id)->get();
            $data['list'] = $list;
            $data['phim'] = $phim;
            $data['token'] = $token;

            $data['title'] = 'Danh Sách Tập - '.$phim[0]->phim_ten;
            $data['page'] = 'admin.phim.list';        
            return view('admin/layout', $data);
        } else {
            $data['title'] = 'Không tìm thấy trang';
            $data['page'] = 'errors.404';
            $data['backURL'] = URL::to('/quan-ly/phim');
            return view('errors/index', $data);            
        }
    }
    
    function addPhim(Request $request){
        $valid = true;        
        if(empty(trim($request->add_phim_ten))){
            $data['add_phim_ten_error'] = 'Tên phim là bắt buộc';
            $valid = false;
        } else if(strlen(trim($request->add_phim_ten)) > 100){
            $data['add_phim_ten_error'] = 'Tên phim có độ dài tối đa 100 ký tự';
            $valid = false;
        }         
        if(empty($request->add_phim_season)){
            $data['add_phim_season_error'] = 'Season phim không được bỏ trống';
            $valid = false;
        }
        if($request->add_phim_nam < 1980 || $request->add_phim_nam > date('Y')){
            $data['add_phim_nam_error'] = 'Năm phát hành hợp lệ phải từ năm 1980 - '.date('Y');
            $valid = false;
        }
        if(empty($request->add_phim_image) && empty($request->add_phim_image_link)){            
            $data['add_phim_image_error'] = 'Ảnh icon của phim là bắt buộc';
            $valid = false;
        }         
        if(empty($request->phim_background) && empty($request->phim_background_link)){            
            $data['phim_background_error'] = 'Ảnh nền của phim là bắt buộc';
            $valid = false;
        }       
        if(empty($request->add_phim_theloai)){
            $data['add_phim_theloai_error'] = 'Phim phải thuộc ít nhất 1 thể loại';
            $valid = false;
        }
                
        if($valid){
            $url_icon = "";
            $url_background = "";
            if(!empty($request->add_phim_image)){
                $path = ClassCommon::getPathUploadImage().Session::get('fileImagePhim');
                rename(ClassCommon::getPathUploadTemp().Session::get('fileImagePhim'), $path);
                $url_icon = URL::to('/').'/'.$path;
            } else {
                $url_icon = $request->add_phim_image_link;
            }
            if(!empty($request->phim_background)){
                $path = ClassCommon::getPathUploadImage().Session::get('fileBackgroundPhim');
                rename(ClassCommon::getPathUploadTemp().Session::get('fileBackgroundPhim'), $path);
                $url_background = URL::to('/').'/'.$path;
            } else {
                $url_background = $request->phim_background_link;
            }
            if(!empty($request->phim_thumb)){
                $path = ClassCommon::getPathUploadImage().Session::get('fileThumbPhim');
                rename(ClassCommon::getPathUploadTemp().Session::get('fileThumbPhim'), $path);
                $url_thumb = URL::to('/').'/'.$path;
            } else {
                $url_thumb = $request->phim_thumb_link;
            }

            $isanime = 1;
            $xuatban = 0;
            if($request->no_anime){
                $isanime = 0;
            }
            if($request->add_phim_xuatban){
                $xuatban = 1;
            }
            DB::table('phim')->insert(
                    [
                        'theloai_id'      => json_encode($request->add_phim_theloai),
                        'phim_ten'        => trim($request->add_phim_ten),
                        'phim_tenvn'    => trim($request->add_phim_tenvn),
                        'phim_tenkhac'    => trim($request->add_phim_tenkhac),
                        'phim_gioithieu'  => $request->add_phim_gioithieu,
                        'phim_sotap'      => $request->add_phim_sotap,
                        'phim_nam'        => $request->add_phim_nam,
                        'phim_season'     => $request->add_phim_season,
                        'quocgia_id'      => $request->add_phim_quocgia,
                        'phim_kieu'       => $request->loaiphim,
                        'phim_dotuoi'     => $request->add_phim_dotuoi,
                        'phim_tag'        => $request->add_phim_tag,
                        'phim_hinhanh'    => $url_icon,
                        'phim_hinhnen'    => $url_background,
                        'phim_thumb'      => $url_thumb,
                        'phim_nguon'      => $request->add_phim_nguon,
                        'phim_anime'      => $isanime,
                        'phim_xuatban'    => $xuatban,
                        'phim_ngaycapnhat'=> now()
                    ]
                );
            return redirect(Session::get('backURLAdmin'))->with('success', 'Cập nhật thành công !');
        } else {
            $listTheLoai = DB::table('theloai')->orderByRaw('theloai_ten')->get();
            $data['listTheLoai'] = $listTheLoai;
            $listQuocGia = DB::table('quocgia')->get();
            $data['listQuocGia'] = $listQuocGia;
            $data['title'] = 'Thêm Phim';
            $data['page'] = 'admin.phim.add';        
            return view('admin/layout', $data);
        }
    }
    
    function editPhim(Request $request){
        $valid = true;        
        if(empty(trim($request->edit_phim_ten))){
            $data['edit_phim_ten_error'] = 'Tên phim là bắt buộc';
            $valid = false;
        } else if(strlen(trim($request->edit_phim_ten)) > 100){
            $data['edit_phim_ten_error'] = 'Tên phim có độ dài tối đa 100 ký tự';
            $valid = false;
        }    
        if(empty($request->edit_phim_season)){
            $data['edit_phim_season_error'] = 'Season phim không được bỏ trống';
            $valid = false;
        }
        if($request->edit_phim_nam < 1980 || $request->edit_phim_nam > date('Y')){
            $data['edit_phim_nam_error'] = 'Năm phát hành hợp lệ phải từ năm 1980 - '.date('Y');
            $valid = false;
        }
        if(empty($request->edit_phim_image) && empty($request->edit_phim_image_link)){            
            $data['edit_phim_image_error'] = 'Ảnh icon của phim là bắt buộc';
            $valid = false;
        }        
        if(empty($request->phim_background) && empty($request->phim_background_link)){            
            $data['phim_background_error'] = 'Ảnh nền của phim là bắt buộc';
            $valid = false;
        } 
        if(empty($request->edit_phim_theloai)){
            $data['edit_phim_theloai_error'] = 'Phim phải thuộc ít nhất 1 thể loại';
            $valid = false;
        }
        if($valid){      
            if(strcmp(Session::get('phim_hinhanh'), $request->edit_phim_image)){
                $url_icon = "";
                $url_background = "";
                if(!empty($request->edit_phim_image)){
                    $path = ClassCommon::getPathUploadImage().Session::get('fileImagePhim');
                    rename(ClassCommon::getPathUploadTemp().Session::get('fileImagePhim'), $path);
                    $url_icon = URL::to('/').'/'.$path;
                } else {
                    $url_icon = $request->edit_phim_image_link;
                }
                if(!empty($request->phim_background)){
                    $path = ClassCommon::getPathUploadImage().Session::get('fileBackgroundPhim');
                    rename(ClassCommon::getPathUploadTemp().Session::get('fileBackgroundPhim'), $path);
                    $url_background = URL::to('/').'/'.$path;
                } else {
                    $url_background = $request->phim_background_link;
                }
                if(!empty($request->phim_thumb)){
                    $path = ClassCommon::getPathUploadImage().Session::get('fileThumbPhim');
                    rename(ClassCommon::getPathUploadTemp().Session::get('fileThumbPhim'), $path);
                    $url_thumb = URL::to('/').'/'.$path;
                } else {
                    $url_thumb = $request->phim_thumb_link;
                }
                
                // Xóa file cũ
                //$phim = DB::table('phim')->where('phim_id', $request->edit_phim_id)->get();
                //$str = explode("/", $phim[0]->phim_hinhanh);
                //$file_name = end($str);
                //if (file_exists(ClassCommon::getPathUploadImage().$file_name)){
                //    unlink(ClassCommon::getPathUploadImage().$file_name);
                //}
                //$str = explode("/", $phim[0]->phim_hinhnen);
                //$file_name = end($str);
                //if (file_exists(ClassCommon::getPathUploadImage().$file_name)){
                //    unlink(ClassCommon::getPathUploadImage().$file_name);
                //}
                
                DB::table('phim')->where('phim_id', $request->edit_phim_id)->update(
                    [                        
                        'phim_hinhanh'        => $url_icon,
                        'phim_hinhnen'        => $url_background,
                        'phim_thumb'          => $url_thumb
                    ]
                );
            }
            
            $isanime = 1;            
            if(isset($request->no_anime) && $request->no_anime == 1){
                $isanime = 0;
            }
            $xuatBan = 0;
            if(isset($request->edit_phim_xuatban) && $request->edit_phim_xuatban == 1){
                $xuatBan = 1;
            }
            $hoanThanh = 0;
            if(isset($request->phim_hoanthanh) && $request->phim_hoanthanh == 1){
                $hoanThanh = 1;
            }
            DB::table('phim')->where('phim_id', $request->edit_phim_id)->update(
                    [
                        'theloai_id'      => json_encode($request->edit_phim_theloai),
                        'phim_ten'        => trim($request->edit_phim_ten),
                        'phim_tenvn'      => trim($request->edit_phim_tenvn),
                        'phim_tenkhac'    => trim($request->edit_phim_tenkhac),
                        'phim_gioithieu'  => $request->edit_phim_gioithieu,
                        'phim_sotap'      => $request->edit_phim_sotap,
                        'phim_nam'        => $request->edit_phim_nam,
                        'phim_season'     => $request->edit_phim_season,
                        'quocgia_id'      => $request->edit_phim_quocgia,
                        'phim_kieu'       => $request->loaiphim,
                        'phim_dotuoi'     => $request->edit_phim_dotuoi,
                        'phim_tag'        => $request->edit_phim_tag,
                        'phim_nguon'      => $request->edit_phim_nguon,
                        'phim_anime'      => $isanime,
                        'phim_xuatban'    => $xuatBan,
                        'phim_hoanthanh'  => $hoanThanh
                    ]
                );            
            return redirect(Session::get('backURLAdmin'))->with('success', 'Cập nhật thành công !');
        } else {
            $phim = DB::table('phim')->where('phim_id', $request->edit_phim_id)->get();
            $listTheLoai = DB::table('theloai')->orderByRaw('theloai_ten')->get();
            $listQuocGia = DB::table('quocgia')->get();
            $data['listQuocGia'] = $listQuocGia;
            $data['phim'] = $phim;
            $data['listTheLoai'] = $listTheLoai;
            $data['token'] = $request->_token;

            $data['title'] = 'Chỉnh Sửa Phim';
            $data['page'] = 'admin.phim.edit';        
            return view('admin/layout', $data);
        }
    }
    
    public function delPhim(Request $request){        
        $phim_id = $request->del_phim_id;        
        $phim = DB::table('phim')->where('phim_id', $phim_id)->get();
        $row = DB::table('phim')->where('phim_id', $phim_id)->delete();
        
        $str = explode("/", $phim[0]->phim_hinhanh);
        $file_name = end($str);
        if (file_exists(ClassCommon::getPathUploadImage().$file_name)){
            unlink(ClassCommon::getPathUploadImage().$file_name);
        }
        if($row > 0){
            return redirect()->route('listPhim')->with('success', 'Xóa thành công !');
        } else {            
            return redirect()->route('listPhim')->with('error', 'Xóa thất bại !');
        }    
    }

    public function addTapPhim(Request $request){
        $thuyetminh = 0;
        if($request->thuyetminh){
            $thuyetminh = 1;
        }
        if($request->is_tap_moi){
            DB::table('tap')->insert(
                [
                    'phim_id'           => $request->add_phim_id,
                    'tap_ten'           => trim($request->add_tapphim_ten),
                    'tap_tapsohienthi'  => trim($request->add_tapphim_taphienthi),
                    'tap_tapso'         => $request->add_tapphim_tap,
                    'tap_thuyetminh'    => $thuyetminh,
                    'tap_facebooklink' => trim($request->facebookLink),
                    'tap_googlelink'    => trim($request->googleLink),
                    'tap_youtubelink'   => trim($request->youtubeLink),
                    'tap_openloadlink'  => trim($request->openloadLink),
                    'tap_luotxem'       => $request->add_tapphim_luotxem,
                    'tap_chatluong'     => $request->chatluong,
                    'tap_ngaycapnhat'   => now()
                ]
            );
            DB::table('phim')->where('phim_id', $request->add_phim_id)->update(
                [
                    'phim_ngaycapnhat_moinhat'    => now()
                ]
            );
        }else{
            DB::table('tap')->insert(
                [
                    'phim_id'           => $request->add_phim_id,
                    'tap_ten'           => trim($request->add_tapphim_ten),
                    'tap_tapsohienthi'  => trim($request->add_tapphim_taphienthi),
                    'tap_tapso'         => $request->add_tapphim_tap,
                    'tap_thuyetminh'    => $thuyetminh,
                    'tap_facebooklink' => trim($request->facebookLink),
                    'tap_googlelink'    => trim($request->googleLink),
                    'tap_youtubelink'   => trim($request->youtubeLink),
                    'tap_openloadlink'  => trim($request->openloadLink),
                    'tap_luotxem'       => $request->add_tapphim_luotxem,
                    'tap_chatluong'     => $request->chatluong
                ]
            );
        }        
        if($request->hoanthanh){
            DB::table('phim')->where('phim_id', $request->add_phim_id)->update(
                [
                    'phim_hoanthanh'    => 1
                ]
            );  
        } 
        if($request->add_tapphim_luotxem>0){
            ClassCommon::updateLuotXem($request->add_phim_id, $request->add_tapphim_luotxem);     
        }   
        if ($request->thongbao){
            ClassCommon::sendPusher($request->add_phim_id, $request->add_tapphim_tap);
        }
        NotificationUtils::sendNotificationOfPhim($request->add_phim_id, $request->add_tapphim_tap, trim($request->add_tapphim_taphienthi));
        $data['status'] = 1;
        return $data;
    }    

    public function addTapPhimFromListTap(Request $request){
        $phim_id = $request->phim_id;
        $token = $request->_token;
        $tap = DB::table('tap')->where([
            ['phim_id', '=', $phim_id],
            ['tap_tapso', '=', $request->add_tapphim_tap]
        ])->count();
        if($tap > 0){
            return redirect()->route('listTap', ['phimID' => $phim_id, 'token' => $token])->with('error', 'Tập này đã có, không thể thêm !');            
        }
        DB::table('tap')->insert(
                    [
                        'phim_id'           => $phim_id,
                        'tap_tapsohienthi'  => trim($request->add_tapphim_taphienthi),
                        'tap_tapso'         => $request->add_tapphim_tap,
                        'tap_luotxem'       => 0,
                        'tap_ngaycapnhat'   => now()
                    ]
                );        
        return redirect()->route('listTap', ['phimID' => $phim_id, 'token' => $token])->with('success', 'Thêm '.trim($request->add_tapphim_taphienthi).' thành công!');
    }
    
    public function editTap($phim_id, $token,Request $request) {
        DB::table('tap')->where([['phim_id', $request->edit_phim_id],['tap_tapso', $request->tapphim_tap]])->update(
                    [                        
                        'tap_ten'           => trim($request->tapphim_ten),
                        'tap_tapsohienthi'  => trim($request->tapphim_taphienthi),                        
                        'tap_facebooklink' => trim($request->facebookLink),
                        'tap_googlelink'    => trim($request->googleLink),
                        'tap_youtubelink'   => trim($request->youtubeLink),
                        'tap_openloadlink'  => trim($request->openloadLink),
                        'tap_luotxem'       => $request->tapphim_luotxem,
                        'tap_chatluong'     => $request->chatluong                        
                    ]
        );
        if($request->tapphim_luotxem > 0){
            ClassCommon::updateLuotXem($request->edit_phim_id, $request->tapphim_luotxem);
        }        
        
        if($request->thongbao){
            ClassCommon::sendPusher($request->edit_phim_id, $request->tapphim_tap);
        }
        return redirect()->route('listTap', ['phimID' => $phim_id, 'token' => $token])->with('success', 'Cập nhật '.$request->tapphim_taphienthi.' thành công !');        
    }
    
    public function editTapAndNext($phim_id, $token,Request $request) {
        DB::table('tap')->where([['phim_id', $request->edit_phim_id],['tap_tapso', $request->tapphim_tap]])->update(
                    [                        
                        'tap_ten'           => trim($request->tapphim_ten),
                        'tap_tapsohienthi'  => trim($request->tapphim_taphienthi),                        
                        'tap_facebooklink' => trim($request->facebookLink),
                        'tap_googlelink'    => trim($request->googleLink),
                        'tap_youtubelink'   => trim($request->youtubeLink),
                        'tap_openloadlink'  => trim($request->openloadLink),
                        'tap_luotxem'       => $request->tapphim_luotxem                        
                    ]
        );
        $tap = DB::table('tap')->where([
                ['phim_id', $phim_id],
                ['tap_tapso', ($request->tapphim_tap+1)]
            ])->get();
        
        if($request->thongbao){
            ClassCommon::sendPusher($request->edit_phim_id, $request->tapphim_tap);
        }
        return $tap;        
    }
    
    public function delTap(Request $request){        
        $tap_id = $request->del_tap_id;                
        $row = DB::table('tap')->where('tap_id', $tap_id)->delete();                
        if($row > 0){
            return redirect()->route('listTap', ['phimID' => $request->phim_id, 'token' => $request->_token])->with('success', 'Xóa tập '.$request->del_tap_hienthi.' thành công !');
        } else {            
            return redirect()->route('listTap', ['phimID' => $request->phim_id, 'token' => $request->_token])->with('error', 'Xóa tập '.$request->del_tap_hienthi.' thất bại !');
        }    
    }
    
    public function getMaxTapPhim(Request $request){
        $tap = DB::table('tap')->where('phim_id', $request->phim_id)->orderByRaw('tap_tapso DESC')->limit(1)->get();
        return $tap[0]->tap_tapso;
    }
    
    public function getComments(){
        return CommentUtils::getHTMLComments(Input::get('pid'));
    }
            
    public function uploadImage(Request $request) {
        if($request->hasFile('image')){
            // chuyển file về thư mục cần lưu trữ
            $file = $request->image;    
            $newName=time();    
            $filePath = $file->move(ClassCommon::getPathUploadTemp(), $newName.'_'.$file->getClientOriginalName());
            if(strcmp('icon', $request->type) == 0){
                session(['fileImagePhim' => $newName.'_'.$file->getClientOriginalName()]);
            } else if(strcmp('background', $request->type) == 0) {
                session(['fileBackgroundPhim' => $newName.'_'.$file->getClientOriginalName()]);
            } else {
                session(['fileThumbPhim' => $newName.'_'.$file->getClientOriginalName()]);
            }
            return $filePath;    
        }
    }
}

