<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "jobs_applies";


    protected $casts = [

        'is_active' => 'boolean', 
       'job_description'=> 'array',

    ];

    // Job_Description

 # Getters

 public function getJobDescriptionAttribute($value)
{
    if ($value == null) {
        return [];
    }
    return json_decode($value, true);
}

}
