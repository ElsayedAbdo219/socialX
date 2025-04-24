<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intro extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['file_name_path'];

    public function getFileNamePathAttribute()
    {
        return url('storage/posts/'.$this->file_name);
    }
    
}
