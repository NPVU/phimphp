<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/quan-ly/', 'QuanLyController@index');

Route::get('/quan-ly/danh-muc/san-pham/', 'SanPhamController@getDanhSachSanPham');

Route::group(['prefix'=>'/quan-ly/nhan-cong/nhan-vien'],function(){
    Route::get('/','NhanVienController@index');
    Route::post('/','NhanVienController@actionIndex');
    
    Route::get('/them-moi','NhanVienController@preAdd');
    Route::post('/them-moi','NhanVienController@actionAdd');
    
    Route::get('/edit','NhanVienController@edit');
    Route::get('/delete','NhanVienController@delete');
});

Route::group(['prefix'=>'/quan-ly/tai-khoan'],function(){
    Route::get('/','TaiKhoanController@index');
    Route::get('/doi-ten-hien-thi/{token}/{displayUserName}','TaiKhoanController@changeDisplayUserName');
    Route::get('/doi-mat-khau/{token}/{oldPassword}/{newPassword}','TaiKhoanController@changePassword');
    Route::post('/upload-avatar','TaiKhoanController@uploadAvatar');
    Route::get('/doi-avatar/{token}','TaiKhoanController@updateAvatar');    
});

Route::group(['prefix'=>'/quan-ly/chi-tieu'],function(){
    Route::get('/','ChiTieuController@index');
    Route::get('/add','ChiTieuController@add');
    Route::get('/edit','ChiTieuController@edit');
    Route::get('/delete','ChiTieuController@delete');
});

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
