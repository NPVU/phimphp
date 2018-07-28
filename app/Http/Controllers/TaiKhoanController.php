<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class TaiKhoanController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    function hasRole(){
        $user = Auth::user();
        $hasRole = DB::table('users_roles')
                ->whereRaw('user_id = '.$user->id.' AND (role_code = '.RoleUtils::getRoleSuperAdmin().' OR role_code = '.RoleUtils::getRoleAdminUser().')')
                ->count();
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
            $count  = DB::table('users')                    
                    ->where('name', 'like', '%'.$tuKhoa.'%')
                    ->orwhere('email', 'like', '%'.$tuKhoa.'%')
//                    ->whereRaw('(role_id <> '.RoleUtils::getRoleSuperAdmin().' OR role_id is null )')                    
                    ->count();
            $listUser = DB::table('users')
                    ->selectRaw('users.*, (SELECT MIN(role_code) FROM users_roles WHERE user_id = id) AS role_code')                    
                    ->where('name', 'like', '%'.$tuKhoa.'%')
                    ->orwhere('email', 'like', '%'.$tuKhoa.'%')
//                    ->whereRaw('(role_id <> '.RoleUtils::getRoleSuperAdmin().' OR role_id is null )')
                    ->paginate(10);
            $listUser->appends(['tukhoa' => $tuKhoa]);
        } else {
            $count = DB::table('users')                    
//                    ->where('users_roles.role_id', '<>', RoleUtils::getRoleSuperAdmin())
//                    ->orwhere('users_roles.role_id', null)
                    ->count();
            $listUser = DB::table('users') 
                    ->selectRaw('users.*, (SELECT MIN(role_code) FROM users_roles WHERE user_id = id) AS role_code')
//                    ->where('users_roles.role_id', '<>', RoleUtils::getRoleSuperAdmin())
//                    ->orwhere('users_roles.role_id', null)                   
                    ->paginate(10);
        
            
        }
        $listRole = DB::table('roles')->get();
        
        $data['listUser'] = $listUser;
        $data['count']    = $count;
        $data['listRole'] = $listRole;
        $data['title'] = 'Danh Sách Tài khoản';
        $data['page'] = 'admin.taikhoan.index';
        return view('admin/layout', $data);
    }
    
    public function lock(Request $request){
        DB::table('users')->where('id', $request->user_id)->update(
            [                        
                'active'        => 0                       
            ]
        );
        return redirect()->route('listTaiKhoan')->with('success', 'Khóa tài khoản '.$request->email.' thành công!');
    }
    
    public function unlock(Request $request){
        DB::table('users')->where('id', $request->user_id)->update(
            [                        
                'active'        => 1                       
            ]
        );
        return redirect()->route('listTaiKhoan')->with('success', 'Mở khóa tài khoản '.$request->email.' thành công!');
    }
    
    public function getRole(Request $request){
        $userRoles = DB::table('users_roles')->select('role_code')->where('user_id', $request->user_id)->get();
        return json_encode($userRoles);
    }
    
    public function changeDisplayUserName($token, $displayUserName){
        if(strcmp(Session::token(), $token) == 0){
            $user = Auth::user();
            $user->name = $displayUserName;
            $user->save();
            $data['status'] = 1;
            $data['msg'] = $displayUserName;
            return $data;
        } else {
            $data['status'] = 0;
            $data['msg'] = 'token session không đúng, vui lòng đăng nhập lại !';
            return $data;
        }
    }
    
    public function changePassword($token, $oldPassword, $newPassword){ 
        if(strcmp(Session::token(), $token) == 0){
            if (!(Hash::check($oldPassword, Auth::user()->password))) {
               $data['status'] = 0;
               $data['msg'] = 'Mật khẩu cũ không đúng !';
               return $data;
            }     
            if(strcmp($oldPassword, $newPassword) == 0){ 
               $data['status'] = 0;
               $data['msg'] = 'Mật khẩu cũ và mật khẩu mới không được giống nhau !';
               return $data;
            }
            $user = Auth::user();
            $user->password = bcrypt($newPassword);
            $user->save();            
        } else {
            $data['status'] = 0;
            $data['msg'] = 'token session không đúng, vui lòng đăng nhập lại !';
            return $data;
        }
        $data['status'] = 1;
        return $data;
    }
    
    public function uploadAvatar(Request $request) {
        if($request->hasFile('avatar')){
            // chuyển file về thư mục cần lưu trữ
            $file = $request->avatar;    
            $newName=time();    
            $filePath = $file->move(ClassCommon::getPathUploadTemp(), $newName.'_'.$file->getClientOriginalName());
            session(['fileAvatarName' => $newName.'_'.$file->getClientOriginalName()]);
            return $filePath;    
        }
    }
    public function updateAvatar($token){
        if(strcmp(Session::token(), $token) == 0){
            $path = ClassCommon::getPathUploadAvatar().Session::get('fileAvatarName');
            rename(ClassCommon::getPathUploadTemp().Session::get('fileAvatarName'), $path);
            $user = Auth::user();
            $user->avatar = $path;
            $user->save();
            $data['status'] = 1;
            $data['msg'] = $path;
            return $data;
        } else {
           $data['status'] = 0;
            return $data;
        }
    }
}

