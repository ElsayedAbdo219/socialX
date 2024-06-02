<?php

namespace App\Notifications;

class AdminNotification extends BaseNotification
{
    public function __construct($notificationData, $notificationVia = ['mail', 'database'])
    {
        $this->notificationVia = $notificationVia;
        parent::__construct($notificationData);
    }

}
