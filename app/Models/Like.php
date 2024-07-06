<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

     protected $guarded=[];
     public function member(){
        return $this->belongsTo(Member::class,'member_id');
    }

}
