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
        'job_description' => 'array',

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




    # relationships

    public function jobAppliers()
    {
        return $this->hasMany(UserApplyJob::class, 'jobs_applies_id');
    }


    public function jobApplierMember()
    {
        return $this->belongsTo(UserApplyJob::class, 'employee_id');
    }



}
