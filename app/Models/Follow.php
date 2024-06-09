<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function followed()
    {
        return $this->belongsTo(Member::class, 'followed_id');
    }

    public function follower()
    {
        return $this->belongsTo(Member::class, 'follower_id');
    }
}
