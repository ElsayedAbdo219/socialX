<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden = ['is_published'];
    protected $appends = ['total_shares'];
    protected $with = ['adsStatus'];
    protected $casts = [
        'is_Active' => 'boolean'
    ];

      protected function FileName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => !is_null($value) ? url('storage/posts/'.$value) : null ,
        );
    }



    public function user(){
        return $this->belongsTo(Member::class,'user_id');
    }

    /* public function creator(){
        return $this->belongsTo(Member::class,'user_id')->hidden(['job','email','is_Active','phone']);
    } */

    public function review(){
        return $this->hasMany(Review::class,'post_id');
    }

    public function likes(){
        return $this->hasMany(Like::class,'post_id');
    }


    public function likesSum()
    {
        return $this->hasMany(Like::class, 'post_id')
                    ->selectRaw('post_id, sum(likes) as total_likes')
                    ->groupBy('post_id');
    }


    public function dislikes(){
        return $this->hasMany(Dislike::class,'post_id');
    }


    public function dislikesSum()
    {
        return $this->hasMany(Dislike::class, 'post_id')
                    ->selectRaw('post_id, sum(dislikes) as total_likes')
                    ->groupBy('post_id');
    }
   

    public function shares()
    {
        return $this->hasMany(SharedPost::class,'post_id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id');
    }


    public function reacts()
    {
        return $this->hasMany(React::class,'post_id');
    }
    
    public function adsStatus()
    {
        return $this->hasOne(AdsStatus::class, 'ads_id');
    }

    public function views()
    {
        return $this->hasMany(VideoView::class, 'video_id');
    }


       # SCOPES

       public function scopeOfName($query,$value){

        return $query->whereHas('user',function($query ) use ($value){

            $query->where('full_name','like',"%$value%");

        });
    }

      public function gettotalSharesAttribute()
      {
        // dd($this->withCount($this->shares()));
        return $this->shares()->count();
      }


}
