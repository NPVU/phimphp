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
use Illuminate\Support\Facades\File;

class UploadPhimController extends Controller{
    
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
    
    public function getUpload(){
        $data['title'] = 'Upload Phim';
        $data['page'] = 'admin.phim.upload';
        return view('admin/layout', $data);
    }

    public function postUpload(Request $request){
        $filename = $request->filename;
        $path  = 'video/'.$request->folder;
        if(!file_exists($path)){
            File::makeDirectory($path,0777,true);
        }
        $video = $path.'/'.$filename;
        copy($request->url, $video);
        return response()->download($video, $filename);
    }
    
}

