<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)            
            ->subject('Yêu Cầu Lấy Lại Mật Khẩu')
            ->greeting('Xin chào!')
            ->line('Chúng tôi vừa nhận được yêu cầu tạo lại mật khẩu của bạn.xin vui lòng click vào nút bên dưới để tạo lại mật khẩu mới.')
            ->action('Reset Password', url('password/reset', $this->token))
            ->line('Nếu bạn không có yêu cầu tạo lại mật khẩu, xin vui lòng bỏ qua thư này.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
