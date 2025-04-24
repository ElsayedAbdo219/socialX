<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','title','description','url','start_month','start_year','end_month','end_year','status'];




    // Relation 
    public function user() 
    {
        return $this->belongsTo(Member::class,'user_id');
    }

    // Scopes 
    public function scopeOfName($query,$value) : string
    {
        return $query->whereHas('user',function($query) use ($value)
        {
           $query->where('name','%'.$value.'%');
        });
    }
}
