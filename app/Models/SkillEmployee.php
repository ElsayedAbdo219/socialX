<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillEmployee extends Model
{
    use HasFactory;
    protected $table = 'skills_employee';
    protected $fillable = ['employee_id','skill_id'];
    protected $with = ['employee','skill'];


    public function employee()
    {
        return $this->belongsTo(Member::class,'employee_id');
    }

    /* public function category()
    {
        return $this->belongsTo(Category::class);
    } */

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }


}
