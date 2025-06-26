<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $casts = [
      'still_working' => 'boolean',
      'start_date' => 'integer',
      'start_date_year' => 'integer',
      'end_date' => 'integer',
      'end_date_year' => 'integer'
    ];


    public function employee(){
        return $this->belongsTo(Member::class,'employee_id');
    }

    public function company(){
        return $this->belongsTo(Member::class,'company_id');
    }




    
}
