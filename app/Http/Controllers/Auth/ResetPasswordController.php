<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm($token){
        $data['token'] = $token;             
        return view('auth.passwords.reset', $data, parent::getDataHeader());
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Yêu Cầu Lấy Lại Mật Khẩu')
            ->line('Chúng tôi vừa nhận được yêu cầu tạo lại mật khẩu cho tài khoản e-mail này.')
            ->action('Reset Password', url('password/reset', $this->token))
            ->line('Nếu bạn không có yêu cầu này, xin vui lòng bỏ qua thư này.');
    }
}
