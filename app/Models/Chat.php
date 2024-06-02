<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use ModelTrait;
    use SoftDeletes;

    protected $fillable = [
        'last_message_id', 'user_id', 'provider_id',
        'driver_id', 'order_id', 'type'];

    # Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class,'order_id');
    }


    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function lastMessageText()
    {
        return $this->messages()?->latest()?->first()?->message_text;
    }

    public function lastMessage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->messages()?->latest()?->first()
        );
    }

}
