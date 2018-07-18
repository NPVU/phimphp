<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClassCommon extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public static function nullOrEmptyString($str){
        return (!isset($str) || trim($str) === '');
    }
    
    public static function getPathUploadAvatar(){
        return 'public/upload/avatar/';
    }
    
    public static function getPathUploadImage(){
        return 'public/upload/image/';
    }
    
    public static function getPathUploadTemp(){
        return 'public/upload/temp/';
    }
    
    public static function showToast(){
        
    }
}
