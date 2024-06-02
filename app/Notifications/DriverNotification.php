<?php

namespace App\Notifications;

class DriverNotification extends BaseNotification
{
    public function __construct($notificationData, $notificationVia = ['firebase', 'database'])
    {
        $this->notificationVia = $notificationVia;
        parent::__construct($notificationData);
    }
}
