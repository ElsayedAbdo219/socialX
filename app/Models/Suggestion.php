<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Suggestion $Suggestion) {
            $Suggestion->user_id = auth()->user()->id;
        });
    }

    protected $guarded = [];

     # Relations
     public function user(): BelongsTo
     {
         return $this->belongsTo(User::class);
     }


}
