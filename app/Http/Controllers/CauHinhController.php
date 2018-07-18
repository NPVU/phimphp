<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as Controller;

class CauHinhController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function indexHeThong($showToast = ''){
        
        $data['title'] = 'Cấu Hình Hệ Thống';
        $data['page'] = 'admin.cauhinh.hethong';
        $data['showToast'] = $showToast;
        return view('admin/layout', $data);
    }
    
    public function actionHeThong(Request $request){
        if(strcmp($request->btn, 'delFileTemp') == 0){
            return $this->delFileTemp();
        } 
    }
    
    function delFileTemp(){
        $files = glob(ClassCommon::getPathUploadTemp().'*'); // get all file names
        $count = 0;
        foreach($files as $file){ // iterate files
            if(is_file($file)){
                unlink($file); // delete file
                $count++;
            }
        }
        return $this->indexHeThong('showToast("success", "", "Đã xóa '.$count.' file rác !", true)');
    }
            
}
