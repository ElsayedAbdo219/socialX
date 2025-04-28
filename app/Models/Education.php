<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

     protected $guarded=[];
     protected $casts = ['still_education' => 'boolean','start_date'=>'integer','start_date_year'=>'integer','end_date'=>'integer','end_date_year'=>'integer'];
}
