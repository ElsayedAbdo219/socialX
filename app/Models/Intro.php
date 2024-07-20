<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intro extends Model
{
    use HasFactory;

    protected $guarded = [];
    
     protected function FileName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => !is_null($value) ? url('storage/posts/'.$value) : null ,
        );
    }

 /*    public function Member(){

    } */
}
