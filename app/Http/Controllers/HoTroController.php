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

class HoTroController extends Controller{
    
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
    
    public function indexError(){
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
        if(!is_null(Input::get('tukhoa'))){
            $tuKhoa = Input::get('tukhoa');
            $count  = DB::table('error_report')
                    ->leftJoin('phim','phim.phim_id','=','error_report.phim_id')                   
                    ->where('phim_ten', 'like', '%'.$tuKhoa.'%')
                    ->orwhere('er_content', 'like', '%'.$tuKhoa.'%')                   
                    ->count();
            $report = DB::table('error_report')
                    ->leftJoin('phim','phim.phim_id','=','error_report.phim_id')    
                    ->leftJoin('tap','tap.tap_id', '=','error_report.tap_id')               
                    ->where('phim_ten', 'like', '%'.$tuKhoa.'%')
                    ->orwhere('er_content', 'like', '%'.$tuKhoa.'%') 
                    ->paginate(10);
            $report->appends(['tukhoa' => $tuKhoa]);
        } else {
            $count = DB::table('error_report')                    
                    ->count();
            $report = DB::table('error_report')
                    ->leftJoin('phim','phim.phim_id','=','error_report.phim_id')
                    ->leftJoin('tap','tap.tap_id', '=','error_report.tap_id')
                    ->paginate(10);                    
        }
        
        $data['listReport'] = $report;
        $data['count']    = $count;        
        $data['title'] = 'Hỗ Trợ - Báo Lỗi';
        $data['page'] = 'admin.hotro.baoloi';
        return view('admin/layout', $data);
    }

    public function deleteError(Request $request){
        if($this->hasRole()){
            if($request->cr_id != 0){
                DB::table('error_report')->where('er_id', $request->cr_id)->delete();               
            }
        }
        return redirect()->route('indexError')->with('success', 'Xóa lỗi thành công!');   
    }


    public function indexYeuCauPhim(){
        if(!$this->hasRole()){
            $data['title'] = 'Không có quyền truy cập';
            $data['page'] = 'errors.401';
            $data['backURL'] = URL::to('/');
            return view('errors/index', $data); 
        }
        if(!is_null(Input::get('tukhoa'))){
            $tuKhoa = Input::get('tukhoa');
            $count  = DB::table('yeucau')                                   
                    ->where('yeucau_email', 'like', '%'.$tuKhoa.'%')
                    ->orwhere('yeucau_content', 'like', '%'.$tuKhoa.'%')                   
                    ->count();
            $yeucau = DB::table('yeucau')             
                    ->where('yeucau_email', 'like', '%'.$tuKhoa.'%')
                    ->orwhere('yeucau_content', 'like', '%'.$tuKhoa.'%') 
                    ->paginate(10);
            $yeucau->appends(['tukhoa' => $tuKhoa]);
        } else {
            $count = DB::table('yeucau')                    
                    ->count();
            $yeucau = DB::table('yeucau')
                    ->paginate(10);                    
        }
        
        $data['listYeuCau'] = $yeucau;
        $data['count']    = $count;        
        $data['title'] = 'Hỗ Trợ - Yêu Cầu Phim';
        $data['page'] = 'admin.hotro.yeucau';
        return view('admin/layout', $data);
    }

    public function deleteYeuCauPhim(Request $request){
        if($this->hasRole()){
            if($request->cr_id != 0){
                DB::table('yeucau')->where('yeucau_id', $request->cr_id)->delete();               
            }
        }
        return redirect()->route('indexYeuCauPhim')->with('success', 'Xóa yêu cầu thành công!');   
    }
        
}

