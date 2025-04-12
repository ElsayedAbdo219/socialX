<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedPost extends Model
{
    use HasFactory;
    protected $table = 'shared_posts';

    protected $fillable = ['post_id','user_id','comment'] ;

    # Relations
    public function post() 
    {
      return $this->belongsTo(Post::class,'post_id');
    }
    public function userShared() 
    {
      return $this->belongsTo(Member::class,'user_id');
    }

}
