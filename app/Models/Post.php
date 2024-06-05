<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function company(){
        return $this->belongsTo(Member::class,'company_id');
    }

    public function review(){
        return $this->hasMany(Review::class,'post_id');
    }




}
