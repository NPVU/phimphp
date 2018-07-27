<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as Controller;

class CauHinhController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function hasRole(){
        $user = Auth::user();
        $hasRole = DB::table('users_roles')->whereRaw('user_id = '.$user->id.' AND role_id = 100 ')->count();
        return $hasRole>0?true:false;
    }
    
    public function indexHeThong(){
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
        $files = glob(ClassCommon::getPathUploadTemp().'*');
        $count = 0;
        if ($files){
            $count = count($files);
        }        
        
        $data['count'] = $count;
        $data['title'] = 'Cấu Hình Hệ Thống';
        $data['page'] = 'admin.cauhinh.hethong';
        return view('admin/layout', $data);
    }
    
    public function actionHeThong(Request $request){
        if(strcmp($request->btn, 'delFileTemp') == 0){
            return $this->delFileTemp();
        } 
    }
    
    function delFileTemp(){
        $files = glob(ClassCommon::getPathUploadTemp().'*'); 
        $count = 0;
        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
                $count++;
            }
        }
        return redirect()->route('indexHeThong')->with('success', 'Đã xóa '.$count.' file rác !');        
    }
            
}
