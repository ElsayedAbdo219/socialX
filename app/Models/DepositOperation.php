<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositOperation extends Model
{
    use HasFactory;

    protected $table = 'deposit_operations';

    protected $appends = ['type_translated'];

    public function getTypeTranslatedAttribute()
    {
        return __('messages.' . $this->type);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (DepositOperation $DepositOperation) {
            $DepositOperation->user_id = auth()->user()->id;
        });
    }

    protected $guarded = [];

    #Relations
    public function trader()
    {
        return $this->belongsTo(Trader::class, 'trader_id');
    }


     public function user()
     {
         return $this->belongsTo(User::class, 'user_id');
     }


    public function depositAnother()
    {
        return $this->belongsTo(Trader::class, 'deposit_another_id');
    }

    # Scopes

    public function scopeOfType($query, $value)
    {
        return $query->where('type', $value);
    }

    public function scopeOfUser($query, $value)
    {
        return $query->where('user_id', $value);
    }

}
