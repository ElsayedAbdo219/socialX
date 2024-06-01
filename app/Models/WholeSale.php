<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WholeSale extends Model
{
    use HasFactory;

    protected $appends = ['type_translated'];

    public function getTypeTranslatedAttribute()
    {
        return __('messages.whole_selling');
    }
    public static function boot()
    {

        parent::boot();
        static::creating(function (WholeSale $WholeSale) {
            $WholeSale->user_id = auth()->user()->id;
        });
    }


    protected $guarded = [];


    #Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'trader_id');
    }

    public function goodType()
    {
        return $this->belongsTo(GoodType::class, 'goods_type_id');
    }


     #scopes
    public function scopeOfName($query, $value)
    {
        if (empty($value)) return $query;
        return $query->whereHas('trader', fn($query) => $query->where('name', 'like', "%$value%"));
    }


       public function scopeOfUser($query, $value)
    {
        return $query->where('user_id', $value);
    }



}
