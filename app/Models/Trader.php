<?php

namespace App\Models;

use App\Enum\UserTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trader extends Model
{
    use HasFactory;

    protected $guarded = [];

    #Relations

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchasing()
    {
        return $this->hasMany(purchasing::class, 'trader_id');
    }


    public function sectoralSelling()
    {
        return $this->hasMany(SectoralSelling::class, 'trader_id');
    }

    public function wholeSale()
    {
        return $this->hasMany(WholeSale::class, 'trader_id');
    }

    public function depositOperation()
    {
        return $this->hasMany(DepositOperation::class, 'trader_id');
    }

    public function financial(): HasOne
    {
        return $this->hasOne(FinancialUser::class,'trader_id');
    }

 

    #scopes
    public function scopeOfName($query, $value)
    {
        if (empty($value)) return $query;
        return $query->where('name', 'like', "%$value%");
    }

    public function scopeOfType($query, $value)
    {
        $value = is_array($value) ? $value : [$value];
        return $query->whereIn('type', $value);
    }

    public function scopeOfUser($query, $value)
    {
        return $query->where('user_id', $value);
    }




    
}
