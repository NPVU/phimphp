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
        $countReport = DB::select(DB::raw('SELECT count(1) as tong FROM binhluan_report report '
                                            .   ' LEFT JOIN binhluan ON binhluan.binhluan_id = report.binhluan_id '
                                            .   ' LEFT JOIN users ON users.id = binhluan.user_id '                                            
                                            .   ' WHERE users.active = 1 '));
        $listReport = DB::select(DB::raw('SELECT report.*, users.id, avatar, name, email, phim_ten, binhluan_noidung FROM binhluan_report report '
                                            .   ' LEFT JOIN binhluan ON binhluan.binhluan_id = report.binhluan_id '
                                            .   ' LEFT JOIN users ON users.id = binhluan.user_id '
                                            .   ' LEFT JOIN phim ON phim.phim_id = binhluan.phim_id '
                                            .   ' WHERE users.active = 1 '));
        $listRole = DB::table('roles')->get();
        
        $data['listUser'] = $listUser;
        $data['count']    = $count;        
        $data['listRole'] = $listRole;
        $data['countReport'] = $countReport;
        $data['listReport'] = $listReport;
        $data['title'] = 'Quản Lý Tài Khoản';
        $data['page'] = 'admin.taikhoan.index';
        return view('admin/layout', $data);
    }
    
    public function lock(Request $request){
        DB::table('users')->where('id', $request->user_id)->update(
            [                        
                'active'        => 0,
                'reason'        => $request->reason,
                'locked_at'     => now()
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
    
    public function addRemoveRole(Request $request){
        if(strcmp('Thêm', $request->action) == 0){
            DB::table('users_roles')->insert(
                [                        
                    'user_id'        => $request->user_id,
                    'role_code'      => $request->role_code
                ]
            );
            return 'added';
        } else {
           DB::table('users_roles')->where([
               ['user_id',$request->user_id],
               ['role_code', $request->role_code]
           ])->delete();
           return 'deleted';
        }            
    }

    public function lockComment(Request $request){
        $user = DB::table('binhluan')->where('binhluan_id', $request->cid)->get();
        DB::table('users')->where('id', $user[0]->user_id)->update(
            [                        
                'active'        => 0,
                'reason'        => 'Khóa vì bình luận vi phạm qui định của website',
                'locked_at'     => now()
            ]
        );
        return 1;
    }

    public function deleteComment(Request $request){
        if($this->hasRole()){
            if($request->cid != 0){
                DB::table('binhluan')->where('binhluan_id_cha', $request->cid)->delete();
                DB::table('binhluan')->where('binhluan_id', $request->cid)->delete();
                DB::table('binhluan_report')->where('binhluan_id', $request->cid)->delete();
            }
        }
        return redirect()->route('listTaiKhoan')->with('success', 'Xóa bình luận thành công!');   
    }

    public function deleteReport(Request $request){
        DB::table('binhluan_report')->where('cr_id', $request->cr_id)->delete();
        return redirect()->route('listTaiKhoan')->with('success', 'Xóa report thành công!');       
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
            $data['msg'] = 'token session không đúng, vui lòng đăng nhập lại ';
            return $data;
        }
    }
    
    public function changePassword($token, $oldPassword, $newPassword){ 
        if(strcmp(Session::token(), $token) == 0){
            if (!(Hash::check($oldPassword, Auth::user()->password))) {
               $data['status'] = 0;
               $data['msg'] = 'Mật khẩu cũ không đúng ';
               return $data;
            }     
            if(strcmp($oldPassword, $newPassword) == 0){ 
               $data['status'] = 0;
               $data['msg'] = 'Mật khẩu cũ và mật khẩu mới không được giống nhau ';
               return $data;
            }
            $user = Auth::user();
            $user->password = bcrypt($newPassword);
            $user->save();            
        } else {
            $data['status'] = 0;
            $data['msg'] = 'token session không đúng, vui lòng đăng nhập lại ';
            return $data;
        }
        $data['status'] = 1;
        $data['msg'] = 'Thay đổi mật khẩu thành công';
        return $data;
    }
    
    public function changeBirthday($token, $newDate){
        if(strcmp(Session::token(), $token) == 0){
            $user = Auth::user();
            $user->birthday = $newDate;
            $user->save();
            $data['status'] = 1;
            $data['msg'] = date_format(date_create($newDate),"m/d/Y");
            $data['value'] = date_format(date_create($newDate),"Y-m-d");
            return $data;
        } else {
            $data['status'] = 0;
            $data['msg'] = 'token session không đúng, vui lòng đăng nhập lại ';
            return $data;
        }
    }
    public function changeGender($token, $gender){
        if(strcmp(Session::token(), $token) == 0){
            $user = Auth::user();
            $user->gender = $gender;
            $user->save();
            $data['status'] = 1;
            $data['msg'] = $gender;
            $data['text'] = $gender==1?'Nam':'Nữ';
            return $data;
        } else {
            $data['status'] = 0;
            $data['msg'] = 'token session không đúng, vui lòng đăng nhập lại ';
            return $data;
        }
    }
    public function changePhone($token, $phone){
        if(strcmp(Session::token(), $token) == 0){
            $user = Auth::user();
            $user->phone = $phone;
            $user->save();
            $data['status'] = 1;
            $data['msg'] = $phone;
            return $data;
        } else {
            $data['status'] = 0;
            $data['msg'] = 'token session không đúng, vui lòng đăng nhập lại ';
            return $data;
        }
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
            if(file_exists($user->avatar)){
                unlink($user->avatar);
            }            
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

