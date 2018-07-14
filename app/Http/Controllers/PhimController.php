<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PhimController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
       $data['title'] = 'Bảng Điều Khiển';
       $data['page'] = 'admin.index';
       return view('admin/layout', $data);
    }
}

