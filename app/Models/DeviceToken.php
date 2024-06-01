<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DeviceToken extends Model
{
    protected $guarded = [];

    # Relations
    public function tokenable(): MorphTo
    {
        return $this->morphTo();
    }
}
