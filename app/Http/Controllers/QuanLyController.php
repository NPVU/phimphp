<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class QuanLyController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function hasRole(){
        $user = Auth::user();
        $hasRole = DB::table('users_roles')->whereRaw('user_id = '.$user->id.' AND (role_code = '.RoleUtils::getRoleSuperAdmin().' OR role_code = '.RoleUtils::getRoleAdminPhim().')')->count();
        return $hasRole>0?true:false;
    }
    
    public function index() {
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }

        $tongPhim = DB::table('phim')->count();
        $phimHoanThanh = DB::table('phim')->where('phim_hoanthanh', 1)->count();

        $data['tongphim'] = $tongPhim;
        $data['phimhoanthanh'] = $phimHoanThanh;

        $data['title'] = 'Bảng Điều Khiển';
        $data['page'] = 'admin.index';
        return view('admin/layout', $data);
    }
}

