<?php

namespace App\Models;

use App\Enum\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchasing extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['type_translated'];

    public function getTypeTranslatedAttribute()
    {
        return $this->type == UserTypeEnum::COMPANY ? __('messages.purshase_from_company') : __('messages.purshase_from_supplier');
    }

    #Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'trader_id');
    }

    /**
     * Get the GoodType that owns the purchasing.
     */
    public function goodType()
    {
        return $this->belongsTo(GoodType::class, 'goods_type_id');
    }


    public function scopeOfName($query, $value)
    {
        if (empty($value)) return $query;
        return $query->whereHas('trader', fn ($query) => $query->where('name', 'like', "%$value%"));
    }

     public function scopeOfType($query, $value)
    {
        return $query->where('type','like', "%$value%");
    }

       public function scopeOfUser($query, $value)
    {
        return $query->where('user_id', $value);
    }

}
