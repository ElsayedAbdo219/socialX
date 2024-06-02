<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialUser extends Model
{
    use HasFactory, ModelTrait;

    protected $guarded = [];

    # Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trader(): BelongsTo //مخزني
    {
        return $this->belongsTo(Trader::class,'trader_id');
    }



     #scopes 

    public function scopeOfCreated($query, $value){
        return $query->where('created_at', 'like', "%$value%");
    }

}
