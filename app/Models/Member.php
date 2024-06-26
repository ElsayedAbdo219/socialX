<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Notifications\Notifiable;


 use Illuminate\Foundation\Auth\User as Authenticatable;


class Member extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;



    protected $guarded=[];


    protected function Logo(): Attribute
    {
        return Attribute::make(function ($value) {
            return !is_null($value) ? url('storage/members/'.$value) : null;
        });
    }

    protected function Coverletter(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => !is_null($value) ? url('storage/members/'.$value) : null,
        );
    }

     protected function PersonalPhoto(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => !is_null($value) ? url('storage/members/'.$value) : null,
        );
    }



   # Relations
    public function followed()
    {
        return $this->hasMany(Follow::class, 'followed_id');
    }

    public function follower()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }


    public function rate(){

        return $this->belongsTo(RateEmployee::class,'employee_id');


    }

   # Scopes
   public function scopeOfName($query, $value)
   {
       if (empty($value)) return $query;
       return $query->where('full_name', 'like', "%$value%");
   }



}
