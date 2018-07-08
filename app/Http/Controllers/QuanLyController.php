<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;

class QuanLyController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
       $data['title'] = 'Bảng Điều Khiển';
       $data['page'] = 'admin.index';
       return view('admin/layout', $data);
    }
}

