<?php

namespace App\Notifications;

use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


class ForgetPasswordNotification extends Notification
{
    use Queueable;

    private $otp;

    public function __construct()
    {
        $this->otp=new Otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $code=$this->otp->generate($notifiable->email,'numeric',4,10);
        return (new MailMessage)
        ->greeting('Hollo '.$notifiable->name)
        ->line('Rest Password ')
        ->line('the Code : '. $code->token)
        // ->action('RestPassword','/')
        ->line('thanks');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
