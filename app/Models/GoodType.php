<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodType extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function purchasing()
    {
        return $this->hasMany(purchasing::class, 'goods_type_id');
    }


    public function sectoralSelling()
    {
        return $this->hasMany(SectoralSelling::class, 'goods_type_id');
    }
    public function wholeSale()
    {
        return $this->hasMany(WholeSale::class, 'goods_type_id');
    }


    #scopes 

    public function scopeOfName($query, $value){
        return $query->where('name', 'like', "%$value%");
    }
}
