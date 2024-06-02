<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasApiTokens,HasFactory,Notifiable;
    protected $guarded=[];



      # Scopes
    public function scopeOfName($query, $value)
    {
        if (empty($value)) return $query;
        return $query->where('name', 'like', "%$value%");
    }

    
}
