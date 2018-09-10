<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm(){             
        return view('auth.passwords.email', parent::getDataHeader());
    }

    public function sendResetLinkEmail(Request $request){
        $this->validate($request, ['email' => 'required|email']);

        $user = DB::table('users')->where('email', $request->email)->get();
        if(count($user) == 0){
            throw ValidationException::withMessages([
                'email' => ['Tài khoản không tồn tại'],            
            ]); 
        } else if($user[0]->active == 1){
            $response = $this->broker()->sendResetLink(
                $request->only('email'), $this->resetNotifier($request->_token) 
            );
    
            switch ($response) {
                case Password::RESET_LINK_SENT:                    
                    throw ValidationException::withMessages([
                        'success' => [true],
                        'email' => ['Đã gửi, vui lòng kiểm tra hộp thư đến hoặc spam'],            
                    ]);  
                case Password::INVALID_USER:
                default:
                    throw ValidationException::withMessages([
                        'email' => ['Tài khoản không tồn tại'],            
                    ]);                    
            }
        } else {
            throw ValidationException::withMessages([
                'email' => ['Tài khoản của bạn đã bị khóa'],            
            ]);
        }
        
    }

    protected function resetNotifier($token)
{
    return function($token)
    {
        return new ResetPasswordNotification($token);
    };
}
}
