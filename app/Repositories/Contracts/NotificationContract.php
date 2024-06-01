<?php

namespace App\Repositories\Contracts;

use App\Models\Notification;

interface NotificationContract extends BaseContract
{
    public function relatedData(Notification $model);
}
