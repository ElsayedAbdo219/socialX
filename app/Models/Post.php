<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function Company(){
        return $this->belongsTo(Company::class,'company_id');
    }

    public function Review(){
        return $this->hasMany(Review::class,'post_id');
    }




}
