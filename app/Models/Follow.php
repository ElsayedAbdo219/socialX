<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function userfollowed()
    {
        return $this->belongsTo(Member::class, 'followed_id');
    }

    public function userfollower()
    {
        return $this->belongsTo(Member::class, 'follower_id');
    }
}
