<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custody extends Model
{
    use HasFactory;

    protected $appends = ['type_translated'];

    public function getTypeTranslatedAttribute()
    {
        return __('messages.custody');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Custody $Custody) {
            $Custody->user_id = auth()->user()->id;
        });
    }

    protected $guarded = [];
     #Relations
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id');
     }



    public function scopeOfUser($query, $value)
    {
        return $query->where('user_id', $value);
    }

}
