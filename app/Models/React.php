<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class React extends Model
{
    use HasFactory;
    protected $fillable = ['post_id' , 'user_id' ,'react_type'] ;
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
}
