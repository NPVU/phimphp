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
        
        $data['phim'] = $phim;
        $data['listTheLoai'] = $listTheLoai;
        $data['token'] = $token;
        
        $data['title'] = 'Chỉnh Sửa Phim';
        $data['page'] = 'admin.phim.edit';        
        return view('admin/layout', $data);
    }
    
    public function actionPhim(Request $request){
        if(strcmp($request->btn, 'add') == 0){
            return $this->addPhim($request);
        } else if(strcmp($request->btn, 'del') == 0){
            return $this->delTheLoai($request);
        } else if(strcmp($request->btn, 'upd') == 0){
            return $this->updTheLoai($request);
        }
    }
    
    function addPhim(Request $request){
        $valid = true;        
        if(empty(trim($request->add_phim_ten))){
            $data['add_phim_ten_error'] = 'Tên phim là bắt buộc';
            $valid = false;
        }
        if($request->add_phim_sotap <= 0){
            $data['add_phim_sotap_error'] = 'Số tập phim phải lớn hơn 0';
            $valid = false;
        }
        if($request->add_phim_nam < 1990 || $request->add_phim_nam > date('Y')){
            $data['add_phim_nam_error'] = 'Năm phát hành phải hợp lệ từ năm 1990 - '.date('Y');
            $valid = false;
        }
        if(empty($request->add_phim_image) && empty($request->add_phim_image_link)){            
            $data['add_phim_image_error'] = 'Ảnh bìa của phim là bắt buộc';
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
                        'phim_ten'        => $request->add_phim_ten,
                        'phim_tenkhac'    => $request->add_phim_tenkhac,
                        'phim_gioithieu'  => $request->add_phim_gioithieu,
                        'phim_sotap'      => $request->add_phim_sotap,
                        'phim_nam'        => $request->add_phim_nam,
                        'phim_tag'        => $request->add_phim_tag,
                        'phim_hinhanh'    => $url,
                        'phim_ngaycapnhat'=> now()
                    ]
                );
            return $this->index('showToast("success", "", "Cập nhật thành công !", true)');
        } else {
            $listTheLoai = DB::table('theloai')->get();
            $data['listTheLoai'] = $listTheLoai;
            $data['title'] = 'Thêm Phim';
            $data['page'] = 'admin.phim.add';        
            return view('admin/layout', $data);
        }
    }
    
    public function xoaPhim($token, $phim_id){
        if(strcmp(Session::token(), $token) == 0){
            $row = DB::table('phim')->where('phim_id', $phim_id)->delete();
            if($row > 0){
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }             
            return $data;
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

