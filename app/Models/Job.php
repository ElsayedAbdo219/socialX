<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'job_name',
        'employee_type',
        'job_period',
        'overview',
        'job_category',
        'job_description',
        'work_level',
        'salary',
        'salary_period',
        'experience',
        'location',
        'is_active'
    ];

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

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function jobAppliers()
    {
        return $this->hasMany(UserApplyJob::class, 'jobs_applies_id');
    }
    # SCOPES

    public function scopeOfName($query,$value){

        return $query->whereHas('member',function($query ) use ($value){

            $query->where('full_name','like',"%$value%");

        });
    }

    public function scopeOfStatus($query, $value)
    {
        if ($value == null) {
            return $query;
        }
        return $query->where('is_Active', $value);
    }

}
