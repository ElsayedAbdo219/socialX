<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use ModelTrait;

    public function notifiable()
    {
        return $this->morphTo();
    }
}
