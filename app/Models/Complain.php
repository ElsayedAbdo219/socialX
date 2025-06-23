<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complain extends Model
{
    use HasFactory;

     protected static function boot()
    {
        parent::boot();
        static::creating(function (Complain $Complain) {
            $Complain->user_id = auth()->user()->id;
        });
    }

    protected $guarded = [];

     # Relations
     public function user(): BelongsTo
     {
         return $this->belongsTo(Member::class);
     }

}
