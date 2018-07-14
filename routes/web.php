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
Route::group(['prefix'=>'/quan-ly/danh-muc/the-loai'],function(){
    Route::get('/','TheLoaiController@index');
    Route::post('/','TheLoaiController@addTheLoai');
});
Route::group(['prefix'=>'/quan-ly/tai-khoan'],function(){
    Route::get('/','TaiKhoanController@index');
    Route::get('/doi-ten-hien-thi/{token}/{displayUserName}','TaiKhoanController@changeDisplayUserName');
    Route::get('/doi-mat-khau/{token}/{oldPassword}/{newPassword}','TaiKhoanController@changePassword');
    Route::post('/upload-avatar','TaiKhoanController@uploadAvatar');
    Route::get('/doi-avatar/{token}','TaiKhoanController@updateAvatar');    
});
Route::group(['prefix'=>'/quan-ly/phim'],function(){
    Route::get('/','PhimController@index');    
});
Route::group(['prefix' => 'services'], function(){
	Route::get('ticket/{file}/{loginkey}/{apikey}', 'ServicesController@openloadTicketAPI');
	Route::get('download/{file}/{loginkey}/{apikey}', 'ServicesController@openloadDownloadAPI');	
});
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
