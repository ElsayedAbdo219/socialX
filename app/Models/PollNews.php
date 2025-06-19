<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollNews extends Model
{
    use HasFactory;
    protected $fillable = [
        'news_id',
        'user_id',
        'yes',
        'no'
    ];
    protected $table = 'poll_news';
    public function news()
    {
        return $this->belongsTo(News::class);
    }
    public function user()
    {
        return $this->belongsTo(Member::class, 'user_id');  
    }
}
