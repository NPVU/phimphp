<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listTheLoai = DB::table('theloai')->get();
        $listNam     = DB::table('phim')->selectRaw('phim_nam as nam')->distinct()->get();
        
        $data['listTheLoai'] = $listTheLoai;
        $data['listNam']     = $listNam;
        return view('home', $data);
    }
}
