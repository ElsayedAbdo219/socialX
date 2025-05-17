<?php

namespace App\Models;
use App\Enum\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use App\Models\Experience;

 use Illuminate\Foundation\Auth\User as Authenticatable;


class Member extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $guarded=[];
    protected $hidden = ['email_verified_at','password','remember_token','logo','avatar','personal_info','personal_photo','coverletter'];
    protected $casts = [
        'is_Active' => 'boolean'
    ];
    protected $appends = ['avatar_path'];

     # Get (accessors)

    public function getavatarPathAttribute()
    {
        if(!is_null($this->avatar)){
            return url('storage/avatars/'.$this->avatar);
        }
        return null;
    }
    protected function Logo(): Attribute
    {
        return Attribute::make(function ($value) 
        {
            return !is_null($value) ? url('storage/members/'.$value) : null;
        });
    }

    protected function Coverletter(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => !is_null($value) ? url('storage/members/'.$value) : null,
        );
    }

   /*  protected function IsActive($value): Attribute
    {
        return (boolean) $value;
    } */

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
    # Count followers in two ways #
    public function followersTotal()
    {
        return $this->hasMany(Follow::class, 'followed_id')->selectraw('followed_id, count(*) as followersTotal')->groupBy('followed_id');
    }
    
    public function followersNumber()
    {
        return $this->follower()->count();
    }

    # End
    

    public function follower()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function followedTotal()
    {
        return $this->hasMany(Follow::class, 'follower_id')->selectraw('follower_id, count(*) as followedTotal')->groupBy('follower_id');
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


    
 # relationships

 public function jobs()
 {
     return $this->hasMany(Job::class, 'member_id');
 }


    public function posts(){

        return $this->hasMany(Post::class,'user_id');   


    }


    public function experience(){
        return $this->hasMany(Experience::class,'employee_id');
    }

    public function currentCompany(){
        return $this->hasMany(Experience::class,'company_id');
    }

    public function skills(){
        return $this->hasMany(SkillEmployee::class,'employee_id');
    }


    public function position(){
        return $this->hasMany(Position::class,'employee_id');
    }


    public function education(){
        return $this->hasMany(Education::class,'employee_id');
    }

    public function Intros()
    {
        return $this->hasMany(Intro::class,'company_id');
    }
   
    public function calender()
    {
        return $this->hasMany(Calender::class, 'member_id');
    }


    
    public function jobApplierIs()
    {
        return $this->hasMany(Job::class, 'employee_id');
    }


    public function UserApplyJob()
    {
        return $this->hasOne(UserApplyJob::class, 'employee_id');
    }

    public function userCover()
    {
        return $this->hasMany(UserCover::class);
    }


    public function shares()
    {
        return $this->hasMany(SharedPost::class,'user_id');
    }

    public function overview()
    {
        return $this->hasMany(OverView::class,'company_id');
    }


        public function employeeOverview()
    {
        return $this->hasMany(OverView::class,'employee_id');
    }
   # Scopes
   public function scopeOfName($query, $value)
   {
       if (empty($value)) return $query;
       return $query->where('full_name', 'like', "%$value%");
   }



}
