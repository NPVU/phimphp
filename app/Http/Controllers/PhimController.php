<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as Controller;

class PhimController extends Controller{
       
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($showToast = ''){
        if(!is_null(Input::get('phim'))){
            $listPhim = DB::table('phim')->where('phim_ten', 'like', '%'.Input::get('phim').'%')->get();
        } else {
            $listPhim = DB::table('phim')->get();
        }
        
        $data['listPhim'] = $listPhim;
        
        $data['title'] = 'Danh Sách Phim';
        $data['page'] = 'admin.phim.index';
        $data['showToast'] = $showToast;
        return view('admin/layout', $data);
    }
    
    public function add(){      
        $listTheLoai = DB::table('theloai')->get();
        $data['listTheLoai'] = $listTheLoai;
        
        $data['title'] = 'Thêm Phim';
        $data['page'] = 'admin.phim.add';        
        return view('admin/layout', $data);
    }
    
    public function edit($token, $phim_id){
        $phim = DB::table('phim')->where('phim_id', $phim_id)->get();
        $listTheLoai = DB::table('theloai')->get();
        session(['phim_hinhanh' => $phim[0]->phim_hinhanh]);        
        $data['phim'] = $phim;
        $data['listTheLoai'] = $listTheLoai;
        $data['token'] = $token;
        
        $data['title'] = 'Chỉnh Sửa Phim';
        $data['page'] = 'admin.phim.edit';        
        return view('admin/layout', $data);
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
            $data['add_phim_image_error'] = 'Ảnh bìa của phim là bắt buộc';
            $valid = false;
        }              
        if(empty($request->add_phim_theloai)){
            $data['add_phim_theloai_error'] = 'Phim phải thuộc ít nhất 1 thể loại';
            $valid = false;
        }
        
        if($valid){
            $url = "";
            if(!empty($request->add_phim_image)){
                $path = ClassCommon::getPathUploadImage().Session::get('fileImagePhim');
                rename(ClassCommon::getPathUploadTemp().Session::get('fileImagePhim'), $path);
                $url = URL::to('/').'/'.$path;
            } else {
                $url = $request->add_phim_image_link;
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
                        'phim_hinhanh'    => $url,
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
            $data['edit_phim_image_error'] = 'Ảnh bìa của phim là bắt buộc';
            $valid = false;
        }        
        if(empty($request->add_phim_theloai)){
            $data['edit_phim_theloai_error'] = 'Phim phải thuộc ít nhất 1 thể loại';
            $valid = false;
        }
        if($valid){      
            if(strcmp(Session::get('phim_hinhanh'), $request->edit_phim_image)){
                $url = "";
                if(!empty($request->edit_phim_image)){
                    $path = ClassCommon::getPathUploadImage().Session::get('fileImagePhim');
                    rename(ClassCommon::getPathUploadTemp().Session::get('fileImagePhim'), $path);
                    $url = URL::to('/').'/'.$path;
                } else {
                    $url = $request->edit_phim_image_link;
                }
                DB::table('phim')->where('phim_id', $request->edit_phim_id)->update(
                    [                        
                        'phim_hinhanh'        => $url                       
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

    public function uploadImage(Request $request) {
        if($request->hasFile('image')){
            // chuyển file về thư mục cần lưu trữ
            $file = $request->image;    
            $newName=time();    
            $filePath = $file->move(ClassCommon::getPathUploadTemp(), $newName.'_'.$file->getClientOriginalName());
            session(['fileImagePhim' => $newName.'_'.$file->getClientOriginalName()]);
            return $filePath;    
        }
    }
}

