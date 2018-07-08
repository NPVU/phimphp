<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;

class ChiTieuController extends Controller{
    
    public function index() {
       $data['title'] = 'DANH SÁCH CHI TIÊU';
       $data['page'] = 'admin.chitieu.index';
       return view('admin/layout', $data);
    }

    public function add() {
       $data['title'] = 'THÊM CHI TIÊU';
       $data['page'] = 'admin.chitieu.add';
       return view('admin/layout', $data);
    }
}

