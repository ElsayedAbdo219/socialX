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


   # Relations
    public function followed()
    {
        return $this->hasMany(Follow::class, 'followed_id');
    }

    public function follower()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

   # Scopes
   public function scopeOfName($query, $value)
   {
       if (empty($value)) return $query;
       return $query->where('full_name', 'like', "%$value%");
   }



}
