<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    use HasFactory;
    protected $guarded=[];


      protected function FileName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => !is_null($value) ? url('storage/posts/'.$value) : null ,
        );
    }



    public function company(){
        return $this->belongsTo(Member::class,'company_id');
    }

    public function review(){
        return $this->hasMany(Review::class,'post_id');
    }



       # SCOPES

       public function scopeOfName($query,$value){

        return $query->whereHas('company',function($query ) use ($value){

            $query->where('full_name','like',"%$value%");

        });
    }





}
