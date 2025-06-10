<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionUser extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','promotion_id','start_date','end_date'];
    
}
