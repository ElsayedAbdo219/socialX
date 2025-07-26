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

    if (!$authUser) {
      return false;
    }
      // dd($authUser->id , $this->followed_id , $this->follower_id); // 4 , 2 , 3
    return self::query()
      ->where('follower_id', $authUser->id) // seperate the logic for clarity
      ->where(function($query) {
        $query->where('followed_id', $this->followed_id)
              ->orWhere('followed_id', $this->follower_id);
      })
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
