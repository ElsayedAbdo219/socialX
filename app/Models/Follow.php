<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
  use HasFactory;

  protected $guarded = [];
  protected $appends = ['is_following_this_follower'];

  public function getIsFollowingThisFollowerAttribute()
  {
    $authUser = auth('api')->user();
    // dd($authUser);
      // dd(env("APP_URL").'/client-api/v1/follow/followers/user/{userID}');
      // dd(request()->url());
    if (!$authUser) {
      return false;
    }
    if(request()->url() == env("APP_URL").'/client-api/v1/follow/followers/user/'.$this->followed_id) {
      // dd('here');
      return self::query()
        ->where('follower_id', $authUser->id)
        ->where('followed_id', $this->follower_id)
        ->exists();
    }
    return self::query()
      ->where('follower_id', $authUser->id) 
      ->where('followed_id', $this->followed_id)
      ->exists();
  }

  public function userfollowed()
  {
    return $this->belongsTo(Member::class, 'followed_id');
  }

  public function userfollower()
  {
    return $this->belongsTo(Member::class, 'follower_id');
  }
}
