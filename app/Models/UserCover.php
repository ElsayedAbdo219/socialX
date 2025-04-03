<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCover extends Model
{
    use HasFactory;
    protected $fillable =['member_id','image','is_primary'];
    protected $appends = ['imagepath'] ;


    #Relations
    public function Member()
    {
        return $this->belongsTo(Member::class);
    }
    #accessors
    public function getImagePathAttribute() 
    {
        return url('storage/user-covers/'.$this->image);
    }


}
