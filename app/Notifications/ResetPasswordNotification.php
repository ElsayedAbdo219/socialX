<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    
     protected $title;
     protected $url;
    public function __construct($title,$url)
    {
       $this->title=$title;
       $this->url=$url;
    }

   
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

  
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage);
                   
    }

   
    public function toArray(object $notifiable): array
    {
        return [
            'title'=>$this->title,
            'url'=>$this->url,
        ];
    }
}
