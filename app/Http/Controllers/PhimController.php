<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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
        $data['title'] = 'Thêm Phim';
        $data['page'] = 'admin.phim.add';        
        return view('admin/layout', $data);
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

