<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
/**
 * Description of RoleUtils
 *
 * @author npvu
 */
class RoleUtils {
    //put your code here
    public static function getRoleSuperAdmin(){
        return 100;
    }
    public static function getRoleAdminUser(){
        return 200;
    }
    public static function getRoleAdminPhim(){
        return 300;
    }
}
