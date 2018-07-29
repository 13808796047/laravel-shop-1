<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Cache;

class EmailVerificationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //我们只需要通过邮件通知，因此这里只需要一个mail
    public function via($notifiable)
    {
        return ['mail'];
    }

    //发送邮件时会调用此方法来构建邮件内容，参数就是App\Models\User对象
    public function toMail($notifiable)
    {
        //使用Laravel内置的str类生成随机字符串的函数，参数就是要生成的字符串长度
        $token = str_random(16);
        //往缓存中写入这个随机字符串，有效时间为30分钟
//        cache('email_verification_' . $notifiable->email, $token, 30);
        Cache::set('email_verification_' . $notifiable->email, $token, 30);
        $url = route('email_verification.verify', ['email' => $notifiable->email, 'token' => $token]);
        return (new MailMessage)
            ->greeting($notifiable->name . '您好')
            ->subject('注册成功,请验证您的邮箱')
            ->line('请点击下方链接验证您的邮箱')
            ->action('验证', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
