<?php

namespace App\Notifications;

class ClientNotification extends BaseNotification
{
    public function __construct($notificationData, $notificationVia = ['mail', 'database'])
    {
        $this->notificationVia = $notificationVia;
        parent::__construct($notificationData);

    }
}
