<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SailDetail extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function trader(){
        return $this->belongsTo(Trader::class);
    }



}
