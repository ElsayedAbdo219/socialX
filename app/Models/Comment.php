<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id' , 'user_id' ,'comment'] ;
    protected $with = ['user'];


    # Relations
    public function post() 
    {
      return $this->belongsTo(Post::class,'post_id');
    }

    public function user() 
    {
      return $this->belongsTo(Member::class,'user_id');
    }

    public function commentsPeplied() 
    {
      return $this->hasMany(CommentReply::class,'comment_id');
    }

    public function ReactsTheComment() 
    {
      return $this->hasMany(ReactComment::class,'comment_id');
    }
}
