<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use HasFactory;

    protected $fillable = ['comment_id' , 'user_id' ,'comment'] ;
    protected $with = ['user'];

    # Relations
    public function comment() 
    {
      return $this->belongsTo(Comment::class,'comment_id');
    }
    public function user() 
    {
      return $this->belongsTo(Member::class,'user_id');
    }
}
