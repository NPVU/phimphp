<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TaiKhoanController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
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

