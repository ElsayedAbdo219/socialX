<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use ModelTrait;
    protected $table = 'notifications';
    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
    ];
    protected $appends = [
        'is_read',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }


    public function getIsreadAttribute()
    {
      if(!$this->read_at) {
            return false;
        }
        return true;
        
    }
}
