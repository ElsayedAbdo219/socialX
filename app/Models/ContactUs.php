<?php

namespace App\Models;

use App\Enum\UserTypeEnum;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactUs extends Model
{
    use ModelTrait;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'mobile',
        'message',
        'message_type',
        'is_responded',
        'respond_message',
    ];

    public $filters = [
        'userName',
        'userMobile',
        'userEmail',
        'type',
        'isResponded',
    ];

    # Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    # Scopes
    public function scopeOfUserName($query, $value): void
    {
        $query->whereHas('user', function ($query) use ($value) {
            $query->where('name', 'like', "%{$value}%");
        })->orWhere('name', 'like', "%{$value}%");
    }

    public function scopeOfUserMobile($query, $value): void
    {
        $query->whereHas('user', function ($query) use ($value) {
            $query->where('mobile', 'like', "%{$value}%");
        })->orWhere('mobile', 'like', "%{$value}%");
    }

    public function scopeOfUserEmail($query, $value): void
    {
        $query->whereHas('user', function ($query) use ($value) {
            $query->where('email', 'like', "%{$value}%");
        })->orWhere('email', 'like', "%{$value}%");
    }

    public function scopeOfType($query, $value): void
    {
        $query->where('message_type', $value);
    }
    public function scopeOfIsResponded($query, $value)
    {
        if (!$value && $value != 0) {
            return $query;
        }
        return $query->where('is_responded', $value);
    }
}
