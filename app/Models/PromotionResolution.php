<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionResolution extends Model
{
    use HasFactory;
    protected $fillable = ['promotion_id','resolution_number'];
    protected $casts = 
    [
      'resolution_number' => 'array'
    ];
  //   // protected $with = ['promotion'];
  //  public function getResolutionNumberAttribute()
  //  {
  //   return json_decode($this->resolution_number,true);
  //  }

    public function promotion()
    {
      return $this->belongsTo(Promotion::class);
    }


    
}
