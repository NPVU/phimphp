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
            
        $listPhimToday = DB::select(DB::raw('SELECT * FROM phim '
                . ' JOIN (SELECT DISTINCT phim_id FROM tap ORDER BY tap_ngaycapnhat DESC LIMIT 10) tap '
                . ' ON phim.phim_id IN (tap.phim_id) ORDER BY phim.phim_id DESC'));            
        for($i = 0; $i < count($listPhimToday); $i++){
            $listPhimToday[$i]->tap = DB::table('tap')
                    ->selectRaw('tap_tapso, tap_tapsohienthi')
                    ->where('phim_id', $listPhimToday[$i]->phim_id) 
                    ->orderByRaw('tap_tapso DESC')
                    ->limit(1)->get();
        }
        
        $data['listTheLoai'] = $listTheLoai;
        $data['listNam']     = $listNam;
        
        $data['listPhimToday'] = $listPhimToday;
        return view('home', $data);
    }
}
