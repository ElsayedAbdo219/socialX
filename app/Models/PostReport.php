<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostReport extends Model
{
    use HasFactory;
    protected $fillable = ['post_id','comment'];
    protected $with = ['post'];

    # Relations
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
