<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
    }
    public function index(Request $request){        
        $listAccess = DB::table('access')->orderByRaw('access_time DESC')->get();                
        
        $data['listAccess'] =  $listAccess;
        $data['page'] = 'admin.access.index';
        $data['title'] = 'Quản Lý Truy Cập';
        return view('admin/layout', $data, parent::getDataHeader());
    }
}
