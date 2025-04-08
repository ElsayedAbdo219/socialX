<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function employee(){
        return $this->belongsTo(Member::class,'employee_id');
    }

    public function company(){
        return $this->belongsTo(Member::class,'company_id');
    }




    
}
