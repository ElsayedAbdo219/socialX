<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name','category_id'];
    protected $with = ['category'];


    public function category(){
        return $this->belongsTo(Category::class);
    }


    public function scopeOfName($query,$value)
    {
      return $query->where('name','LIKE','%'.$value.'%');
    }

    public function scopeOfCategory($query,$value)
    {
      return $query->whereHas('category',function($query) use ($value)
      {
        $query->where('name','LIKE','%'.$value.'%');
      });
    }


    ///2024_05_27_093323_create_skills_table   

    
}
