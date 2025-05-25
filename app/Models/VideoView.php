<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'video_id',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = [
        'user_id' => 'integer',
        'video_id' => 'integer',
    ];
    protected $with = ['user', 'video'];
    public function user()
    {
        return $this->belongsTo(Member::class, 'user_id');
    }
    public function video()
    {
        return $this->belongsTo(Post::class, 'video_id');
    }
    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
    public function scopeOfVideo($query, $videoId)
    {
        return $query->where('video_id', $videoId);
    }
}
