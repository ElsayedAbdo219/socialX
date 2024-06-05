<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use Laravel\Sanctum\HasApiTokens;

use Illuminate\Notifications\Notifiable;


 use Illuminate\Foundation\Auth\User as Authenticatable;


class Member extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;



    protected $guarded=[];


   # Scopes
   public function scopeOfName($query, $value)
   {
       if (empty($value)) return $query;
       return $query->where('name', 'like', "%$value%");
   }



}
