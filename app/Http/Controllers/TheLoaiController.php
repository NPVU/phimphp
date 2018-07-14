<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller as Controller;

class TheLoaiController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($showToast = ''){
        if(!is_null(Input::get('theloai'))){
            $listTheLoai = DB::table('theloai')->where('theloai_ten', 'like', '%'.Input::get('theloai').'%')->get();
        } else {
            $listTheLoai = DB::table('theloai')->get();
        }
                
        $data['listTheLoai'] = $listTheLoai;
        
        $data['title'] = 'Danh Mục Thể Loại';        
        $data['page'] = 'admin.danhmuc.theloai.index';
        $data['showToast'] = $showToast;
        return view('admin/layout', $data);
    }
    
    public function addTheLoai(Request $request){
        $valid = true;
        $theloai_ten = $request->add_theloai_ten;
        
        
        
        $exist = DB::table('theloai')->where('theloai_ten', '=', $theloai_ten)->count();
        if($exist > 0){
            $valid = false;
            return $this->index('showToast("error", "Tên thể loại đã tồn tại", "Cập nhật thất bại !", true)');
        }
        
        if($valid){
            DB::table('theloai')->insert(
                    [
                        'theloai_ten'        => $theloai_ten
                    ]
                );
            return $this->index('showToast("success", "", "Cập nhật thành công !", true)');
        } else {
            
        }        
    }
}

