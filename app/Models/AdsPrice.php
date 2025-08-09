<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Str;

class AdsPrice extends Model
{

  protected $table = 'ads_prices';
  protected $fillable =
  [
    'price', // second price 
    'currency',
    'resolution',
    'type', // video or image
  ];
  protected $casts = [
    'price' => 'float',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];
}
