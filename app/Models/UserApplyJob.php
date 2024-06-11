<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApplyJob extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function job()
    {
        return $this->belongsTo(Job::class, 'jobs_applies_id');
    }


    public function members()
    {
        return $this->belongsTo(Member::class, 'employee_id');
    }


}
