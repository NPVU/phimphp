<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as Controller;

class TheLoaiController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    function hasRole(){
        $user = Auth::user();
        $hasRole = DB::table('users_roles')->whereRaw('user_id = '.$user->id.' AND (role_code = '.RoleUtils::getRoleSuperAdmin().' OR role_code = '.RoleUtils::getRoleAdminPhim().')')->count();
        return $hasRole>0?true:false;
    }
    public function index($showToast = ''){
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
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
    
    public function actionTheLoai(Request $request){
        if(strcmp($request->btn, 'add') == 0){
            return $this->addTheLoai($request);
        } else if(strcmp($request->btn, 'del') == 0){
            return $this->delTheLoai($request);
        } else if(strcmp($request->btn, 'upd') == 0){
            return $this->updTheLoai($request);
        }
        
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
    
    public function delTheLoai(Request $request){        
        $theloai_id = $request->del_theloai_id;
        $theloai_ten = $request->del_theloai_ten;

        $row = DB::table('theloai')->where('theloai_id', $theloai_id)->delete();
        if($row > 0){
            return $this->index('showToast("success", "Thể loại '.$theloai_ten.' đã được xóa", "Xóa thành công !", true)');
        } else {
            return $this->index('showToast("error", "", "Xóa thất bại !", true)');
        }                    
    }
    
    public function updTheLoai(Request $request){        
        $theloai_id         = $request->upd_theloai_id;
        $theloai_ten_old    = $request->upd_theloai_ten_old;
        $theloai_ten_new    = $request->upd_theloai_ten_new;
               
        $row = DB::table('theloai')->where('theloai_id', $theloai_id)->update(['theloai_ten' => $theloai_ten_new]);
        if($row > 0){
            return $this->index('showToast("success", "Thể loại '.$theloai_ten_old
                    .' đã được thay đổi thành '.$theloai_ten_new.'", "Cập nhật thành công !", true)');
        } else {
            return $this->index('showToast("error", "", "Dữ liệu không thay đổi", true)');
        }                    
    }
}

