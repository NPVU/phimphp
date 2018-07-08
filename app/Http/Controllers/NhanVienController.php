<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;
use App\Http\Controllers\ClassCommon as ClassCommon;

class NhanVienController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($showToastr = '') {
       // $showToastr = 'success' or 'error' or ... dùng để show iziToastr sau khi submit form
        
       // lấy danh sách 10 row và tổng số row dùng cho phân trang
       $tongnhanvien = DB::table('nhanvien')->where('nhanvien_tinhtrang', '=', 1)->count();
       $list = DB::table('nhanvien')->where('nhanvien_tinhtrang', '=', 1)->paginate(10);       
       $data['tongnhanvien'] = $tongnhanvien;
       $data['nhanvien'] =  $list;
       
       // Khai báo các biến cho input lọc form (khi submit form vẫn giữ được giá trị lọc)
       $data['hotenFilter'] = "";
       $data['cmndFilter'] = "";
       $data['tinhtrangFilter'] = 1;
       
       // title trang
       $data['title'] = 'Quản Lý Nhân Viên - '.config('constants.company_name');
       
       // đường dân file để include vào layout (dấu '.' thay cho '/')
       $data['page'] = 'admin.nhancong.nhanvien.index';
              
       $data['showToastr'] = $showToastr;
       return view('admin/layout', $data);
    }
    
    public function actionIndex(Request $request){     
        
        // Nếu submit khi nhấn nút tìm (button có name và value = btnFilter)
        if(strcmp($request->btnFilter,'btnFilter') == 0){
            return $this->actionFilter($request);
        }
    }
    
    public function actionFilter(Request $request){
        $hotenFilter     = $request->hotenFilter;
        $cmndFilter      = $request->cmndFilter;
        $tinhtrangFilter = $request->tinhtrangFilter;
        if($tinhtrangFilter == -1){
            $where = " nhanvien_tinhtrang <> $tinhtrangFilter ";
        } else {
            $where = " nhanvien_tinhtrang = $tinhtrangFilter ";
        }
        if(!ClassCommon::nullOrEmptyString($hotenFilter)){
            $where .= " AND nhanvien_hoten like '%$hotenFilter%' ";
        }
        if(!ClassCommon::nullOrEmptyString($cmndFilter)){
            $where .= " AND nhanvien_cmnd like '%$cmndFilter%' ";
        }
        
        // Sử dụng where sql tự viết phải dùng whereRaw
       $list = DB::table('nhanvien')->whereRaw($where)->get();
       $tongnhanvien = DB::table('nhanvien')->whereRaw($where)->count();
       $data['nhanvien'] =  $list;
       $data['tongnhanvien'] =  $tongnhanvien;
       $data['title'] = 'Quản Lý Nhân Viên - '.config('constants.company_name');
       $data['page'] = 'admin.nhancong.nhanvien.index';
       return view('admin/layout', $data, $request->all());
    }

    public function preAdd() {
       date_default_timezone_set("Asia/Ho_Chi_Minh");
       $data['hoten']               = "";
       $data['msg_error_hoten']     = "";
       
       $data['cmnd']                = "";
       $data['msg_error_cmnd']      = "";
       
       $data['gioitinh']            = 1;
       
       $ngaysinh=date_create("1970-01-01");
       $data['ngaysinh']            = date_format($ngaysinh, "d/m/Y");
       $data['msg_error_ngaysinh']  = "";
       
       $data['diachi']              = "";
       $data['sodienthoai']         = "";
       $data['email']               = "";
       $data['ngaybatdaulam']       = date('d/m/Y');
        
       $data['title'] = 'Thêm Nhân Viên - '.config('constants.company_name');
       $data['page'] = 'admin.nhancong.nhanvien.add';
       return view('admin/layout', $data);
    }
    public function actionAdd(Request $request) {
       $valid = true;
       
       $hoten       = $request->hoten;
       $cmnd        = $request->cmnd;
       $gioitinh    = $request->gioitinh;
       $ngaysinh    = $request->ngaysinh;
       $diachi      = $request->diachi;
       $sodienthoai = $request->sodienthoai;
       $email       = $request->email;       
       
       $data['msg_error_hoten']     = "";
       $data['msg_error_cmnd']      = "";
       $data['msg_error_ngaysinh']  = "";
       
       if(empty($hoten)){
           $valid = false;
           $data['msg_error_hoten'] = "Họ tên nhân viên là bắt buộc";
       } else if(strlen($hoten) <= 2) {
           $valid = false;
           $data['msg_error_hoten'] = "Họ tên nhân viên phải có ít nhất 2 ký tự";
       }
       
       if(strlen($cmnd) != 9 && strlen($cmnd) != 12) {
           $valid = false;
           $data['msg_error_cmnd'] = "Số CMND phải có 9 hoặc 12 ký tự";
       } else {
           $exist = DB::table('nhanvien')->where('nhanvien_cmnd', '=', $cmnd)->count();
           if($exist != 0){
               $valid = false;
               $data['msg_error_cmnd'] = "Số CMND đã tồn tại";
           }
       }
       
       if($ngaysinh == null) {
           $valid = false;
           $data['msg_error_ngaysinh'] = "Ngày sinh là bắt buộc";
       }       
       if($valid){
            $hinhanh = "";
            
            // Nếu có upload file (file có name = hinhanh)
            if($request->hasFile('hinhanh')){
                $hinhanh = $this->uploadAvatar($request);
            }
            
            DB::table('nhanvien')->insert(
                [
                    'nhanvien_hoten'        => $hoten,
                    'nhanvien_gioitinh'     => $gioitinh,
                    'nhanvien_ngaysinh'     => $ngaysinh,
                    'nhanvien_diachi'       => $diachi,
                    'nhanvien_cmnd'         => $cmnd,
                    'nhanvien_sodienthoai'  => $sodienthoai,
                    'nhanvien_email'        => $email,
                    'nhanvien_hinhanh'      => $hinhanh,
                    'nhanvien_ngaybatdaulam'=> $request->ngaybatdaulam,
                    'nhanvien_ngaytao'      => date('Y-m-d')
                ]
            );
            return $this->index('success');
       } else{
           $data['title'] = 'Thêm Nhân Viên - '.config('constants.company_name');
           $data['page'] = 'admin.nhancong.nhanvien.add';
           return view('admin/layout', $data, $request->all());
       }       
    } 
    
    public function uploadAvatar($request) {
        // chuyển file về thư mục cần lưu trữ
        $file = $request->hinhanh;    
        $newName=time();
        return $file->move(ClassCommon::getPathUploadAvatar(), $newName.'_'.$file->getClientOriginalName());       
    }       
}

