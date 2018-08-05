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
    Route::post('/','TheLoaiController@actionTheLoai');
});
Route::group(['prefix'=>'/quan-ly/phim'],function(){
    Route::get('/','PhimController@index')->name('listPhim');
    Route::get('/add','PhimController@add');    
    Route::get('/edit/{phimID}/{token}','PhimController@edit');
    Route::get('/danh-sach-tap/{phimID}/{token}','PhimController@listTap')->name('listTap');    
    
    Route::post('/','PhimController@actionPhim');
    Route::post('/add','PhimController@addPhim'); 
    Route::post('/add-episode','PhimController@addTapPhim');
    Route::post('/maxtap-current','PhimController@getMaxTapPhim');
    Route::post('/delete','PhimController@delPhim');
    Route::post('/edit/{phimID}/{token}','PhimController@editPhim');
    Route::post('/danh-sach-tap/{phimID}/{token}','PhimController@editTap');
    Route::post('/danh-sach-tap/{phimID}/{token}/next','PhimController@editTapAndNext');
    Route::post('/danh-sach-tap/delete','PhimController@delTap');
    Route::post('/danh-sach-tap/add','PhimController@addTapPhimFromListTap');    
    Route::post('/upload-image','PhimController@uploadImage');
});
Route::group(['prefix'=>'/quan-ly/tai-khoan'],function(){
    Route::get('/','TaiKhoanController@index')->name('listTaiKhoan');
    Route::get('/change-display-name/{token}/{displayUserName}','TaiKhoanController@changeDisplayUserName');
    Route::get('/change-password/{token}/{oldPassword}/{newPassword}','TaiKhoanController@changePassword');
    
    Route::post('/upload-avatar','TaiKhoanController@uploadAvatar');
    Route::get('/change-avatar/{token}','TaiKhoanController@updateAvatar'); 
    
    Route::post('/lock','TaiKhoanController@lock');
    Route::post('/unlock','TaiKhoanController@unlock');
    
    Route::post('/get-role','TaiKhoanController@getRole');
    Route::post('/add-remove-role','TaiKhoanController@addRemoveRole');
});

Route::group(['prefix'=>'/quan-ly/cau-hinh'],function(){
    Route::get('/he-thong','CauHinhController@indexHeThong')->name('indexHeThong');
    Route::post('/he-thong','CauHinhController@actionHeThong');
});
Route::group(['prefix' => 'services'], function(){
	Route::get('ticket/{file}/{loginkey}/{apikey}', 'ServicesController@openloadTicketAPI');
	Route::get('download/{file}/{loginkey}/{apikey}', 'ServicesController@openloadDownloadAPI');
        Route::get('google', 'ServicesController@googleAPI');
        
        Route::get('/get-info-tap','ServicesController@getInfoTapPhim');
});
Auth::routes();
Route::post('/login', 'Auth\\LoginController@postLogin');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/xem-phim/{str}/', 'XemPhimController@xemPhim')->name('xemPhim');
Route::get('/update/{str}', 'XemPhimController@addLuotXem');
Route::get('/tap-moi/', 'HomeController@xemThemTapMoi')->name('home');
