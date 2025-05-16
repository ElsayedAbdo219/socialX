<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverView extends Model
{
    use HasFactory;
    protected $fillable = ['comment','employee_id','company_id'];
    protected $with = ['employee', 'company'];


    # Relations

    public function employee()
    {
        return $this->belongsTo(Member::class,'employee_id');
    }

    public function company()
    {
        return $this->belongsTo(Member::class,'company_id');
    }
}
