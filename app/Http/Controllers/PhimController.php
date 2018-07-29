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
    
    public function index(){                
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
        if(!is_null(Input::get('tukhoa'))){
            $tuKhoa = Input::get('tukhoa');
            $count = DB::table('phim')                    
                    ->where('phim_ten', 'like', '%'.$tuKhoa.'%')
                    ->orwhere('phim_tag', 'like', '%'.$tuKhoa.'%')
                    ->orwhere('phim_sotap', $tuKhoa)
                    ->count();
            $listPhim = DB::table('phim')
                    ->selectRaw('phim.*, (SELECT MAX(tap.tap_tapso) FROM tap AS tap where tap.phim_id = phim.phim_id) as tap')
                    ->where('phim_ten', 'like', '%'.$tuKhoa.'%')
                    ->orwhere('phim_tag', 'like', '%'.$tuKhoa.'%')
                    ->orwhere('phim_sotap', $tuKhoa)
                    ->paginate(10);
            $listPhim->appends(['tukhoa' => $tuKhoa]);
        } else {
            $count = DB::table('phim')->count();
            $listPhim = DB::table('phim')
                    ->selectRaw('phim.*, (SELECT MAX(tap.tap_tapso) FROM tap AS tap where tap.phim_id = phim.phim_id) as tap')
                    ->paginate(10);
        }        
        
        $data['listPhim'] = $listPhim;
        $data['count'] = $count;        
        $data['title'] = 'Danh Sách Phim';
        $data['page'] = 'admin.phim.index';
        return view('admin/layout', $data);
    }
    
    public function add(){  
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
        $listTheLoai = DB::table('theloai')->get();
        $data['listTheLoai'] = $listTheLoai;
        
        $data['title'] = 'Thêm Phim';
        $data['page'] = 'admin.phim.add';        
        return view('admin/layout', $data);
    }
    
    public function edit($phim_id, $token){
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
        if(strcmp(Session::token(), $token) == 0){
            $phim = DB::table('phim')->where('phim_id', $phim_id)->get();
            $listTheLoai = DB::table('theloai')->get();
            session(['phim_hinhanh' => $phim[0]->phim_hinhanh]); 
            session(['phim_hinhnen' => $phim[0]->phim_hinhnen]); 
            $data['phim'] = $phim;
            $data['listTheLoai'] = $listTheLoai;
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
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
        if(strcmp(Session::token(), $token) == 0){
            $list = DB::table('tap')->where('phim_id', $phim_id)->get();
            $phim = DB::table('phim')->where('phim_id', $phim_id)->get();
            $data['list'] = $list;
            $data['phim'] = $phim;
            $data['token'] = $token;

            $data['title'] = 'Danh sách tập';
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
        if(!empty(trim($request->add_phim_tenkhac)) && strlen(trim($request->add_phim_tenkhac)) > 100){
            $data['add_phim_tenkhac_error'] = 'Tên phim có độ dài tối đa 100 ký tự';
            $valid = false;
        }  
        if($request->add_phim_sotap <= 0){
            $data['add_phim_sotap_error'] = 'Số tập phim phải lớn hơn 0';
            $valid = false;
        }
        if($request->add_phim_nam < 1990 || $request->add_phim_nam > date('Y')){
            $data['add_phim_nam_error'] = 'Năm phát hành hợp lệ phải từ năm 1990 - '.date('Y');
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
            
            DB::table('phim')->insert(
                    [
                        'theloai_id'      => json_encode($request->add_phim_theloai),
                        'phim_ten'        => trim($request->add_phim_ten),
                        'phim_tenkhac'    => trim($request->add_phim_tenkhac),
                        'phim_gioithieu'  => $request->add_phim_gioithieu,
                        'phim_sotap'      => $request->add_phim_sotap,
                        'phim_nam'        => $request->add_phim_nam,
                        'phim_tag'        => $request->add_phim_tag,
                        'phim_hinhanh'    => $url_icon,
                        'phim_hinhnen'    => $url_background,
                        'phim_ngaycapnhat'=> now()
                    ]
                );
            return redirect()->route('listPhim')->with('success', 'Cập nhật thành công !');
        } else {
            $listTheLoai = DB::table('theloai')->get();
            $data['listTheLoai'] = $listTheLoai;
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
        if(!empty(trim($request->edit_phim_tenkhac)) && strlen(trim($request->edit_phim_tenkhac)) > 100){
            $data['edit_phim_tenkhac_error'] = 'Tên phim có độ dài tối đa 100 ký tự';
            $valid = false;
        }        
        if($request->edit_phim_sotap <= 0){
            $data['edit_phim_sotap_error'] = 'Số tập phim phải lớn hơn 0';
            $valid = false;
        }
        if($request->edit_phim_nam < 1990 || $request->edit_phim_nam > date('Y')){
            $data['edit_phim_nam_error'] = 'Năm phát hành hợp lệ phải từ năm 1990 - '.date('Y');
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
                
                // Xóa file cũ
                $phim = DB::table('phim')->where('phim_id', $request->edit_phim_id)->get();
                $str = explode("/", $phim[0]->phim_hinhanh);
                $file_name = end($str);
                if (file_exists(ClassCommon::getPathUploadImage().$file_name)){
                    unlink(ClassCommon::getPathUploadImage().$file_name);
                }
                $str = explode("/", $phim[0]->phim_hinhnen);
                $file_name = end($str);
                if (file_exists(ClassCommon::getPathUploadImage().$file_name)){
                    unlink(ClassCommon::getPathUploadImage().$file_name);
                }
                
                DB::table('phim')->where('phim_id', $request->edit_phim_id)->update(
                    [                        
                        'phim_hinhanh'        => $url_icon,
                        'phim_hinhnen'        => $url_background
                    ]
                );
            }
            DB::table('phim')->where('phim_id', $request->edit_phim_id)->update(
                    [
                        'theloai_id'      => json_encode($request->edit_phim_theloai),
                        'phim_ten'        => trim($request->edit_phim_ten),
                        'phim_tenkhac'    => trim($request->edit_phim_tenkhac),
                        'phim_gioithieu'  => $request->edit_phim_gioithieu,
                        'phim_sotap'      => $request->edit_phim_sotap,
                        'phim_nam'        => $request->edit_phim_nam,
                        'phim_tag'        => $request->edit_phim_tag                        
                    ]
                );
            return redirect()->route('listPhim')->with('success', 'Cập nhật thành công !');
        } else {
           $phim = DB::table('phim')->where('phim_id', $request->edit_phim_id)->get();
            $listTheLoai = DB::table('theloai')->get();

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
        $tap = DB::table('tap')->where([
            ['phim_id', '=', $request->add_phim_id],
            ['tap_tapso', '=', $request->add_tapphim_tap]
        ])->count();
        if($tap > 0){
            $data['status'] = 0;
            $data['msg'] = 'Tập '.$request->add_tapphim_tap.' của phim này đã có, mời bạn vào chức năng chỉnh sửa';
            return $data;
        }
        DB::table('tap')->insert(
                    [
                        'phim_id'           => $request->add_phim_id,
                        'tap_ten'           => trim($request->add_tapphim_ten),
                        'tap_tapsohienthi'  => trim($request->add_tapphim_taphienthi),
                        'tap_tapso'         => $request->add_tapphim_tap,
                        'tap_localhostlink' => trim($request->localhostLink),
                        'tap_googlelink'    => trim($request->googleLink),
                        'tap_youtubelink'   => trim($request->youtubeLink),
                        'tap_openloadlink'  => trim($request->openloadLink),
                        'tap_luotxem'       => $request->add_tapphim_luotxem,
                        'tap_ngaycapnhat'   => now()
                    ]
                );
        $data['status'] = 1;
        return $data;
    }
    
    public function editTap($phim_id, $token,Request $request) {
        DB::table('tap')->where([['phim_id', $request->edit_phim_id],['tap_tapso', $request->tapphim_tap]])->update(
                    [                        
                        'tap_ten'           => trim($request->tapphim_ten),
                        'tap_tapsohienthi'  => trim($request->tapphim_taphienthi),                        
                        'tap_localhostlink' => trim($request->localhostLink),
                        'tap_googlelink'    => trim($request->googleLink),
                        'tap_youtubelink'   => trim($request->youtubeLink),
                        'tap_openloadlink'  => trim($request->openloadLink),
                        'tap_luotxem'       => $request->tapphim_luotxem                        
                    ]
        );
        return redirect()->route('listTap', ['phimID' => $phim_id, 'token' => $token])->with('success', 'Cập nhật '.$request->tapphim_tap.' thành công !');        
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
            
    public function uploadImage(Request $request) {
        if($request->hasFile('image')){
            // chuyển file về thư mục cần lưu trữ
            $file = $request->image;    
            $newName=time();    
            $filePath = $file->move(ClassCommon::getPathUploadTemp(), $newName.'_'.$file->getClientOriginalName());
            if(strcmp('icon', $request->type) == 0){
                session(['fileImagePhim' => $newName.'_'.$file->getClientOriginalName()]);
            } else {
                session(['fileBackgroundPhim' => $newName.'_'.$file->getClientOriginalName()]);
            }
            return $filePath;    
        }
    }
}

