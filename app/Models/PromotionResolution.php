<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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



    public function getCreatedAtAttribute($value)
  {
    return Carbon::parse($value)->format('Y-m-d');
  }

  public function getUpdatedAtAttribute($value)
  {
    return Carbon::parse($value)->format('Y-m-d');
  }
    
}
