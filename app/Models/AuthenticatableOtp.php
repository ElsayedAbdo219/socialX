<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthenticatableOtp extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "authenticatable_otp";

    public const EXPIRATION_TIME = 3; // minutes

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * True if the token is not used nor expired
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->isActive() && !$this->isExpired();
    }

    /**
     * Is the current token used
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Is the current token expired
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->created_at->diffInMinutes(Carbon::now()) > static::EXPIRATION_TIME;
    }
}
