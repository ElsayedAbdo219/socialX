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

    public function followersTotal()
    {
        return $this->hasMany(Follow::class, 'followed_id')->selectraw('followed_id, count(*) as followersTotal')->groupBy('followed_id');
    }

    

    public function follower()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }


    public function rateEmployee(){

        return $this->hasMany(RateEmployee::class,'employee_id');


    }

    public function rateEmployeeTotal(){
        return $this->hasMany(RateCompany::class,'employee_id')->selectraw('employee_id, round(sum(rate) / count(*),1) as rateCompanyTotal')->groupBy('employee_id');

    }



    public function rateCompany(){

        return $this->hasMany(RateCompany::class,'company_id');


    }


    public function rateCompanyTotal(){
        return $this->hasMany(RateCompany::class,'company_id')->selectraw('company_id, round(sum(rate) / count(*),1) as rateCompanyTotal')->groupBy('company_id');

    }


    



    public function posts(){

        return $this->hasMany(Post::class,'company_id');   


    }


    public function experience(){
        return $this->hasMany(Experience::class,'employee_id');
    }

    public function skills(){
        return $this->hasMany(Skill::class,'employee_id');
    }


    public function position(){
        return $this->hasMany(Skill::class,'employee_id');
    }


    public function education(){
        return $this->hasMany(Skill::class,'employee_id');
    }


    
    

   # Scopes
   public function scopeOfName($query, $value)
   {
       if (empty($value)) return $query;
       return $query->where('full_name', 'like', "%$value%");
   }



}
