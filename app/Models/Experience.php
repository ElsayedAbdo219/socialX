<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function member(){
        return $this->hasOne(Member::class,'employee_id');
    }


    
}
