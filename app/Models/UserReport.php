<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    use HasFactory;

    protected $guarded=[];


     # Relations
     public function user()
     {
         return $this->belongsTo(User::class);
     }


     public function scopeOfUser($query, $value)
     {
         return $query->where('user_id', $value);
     }

     



}
