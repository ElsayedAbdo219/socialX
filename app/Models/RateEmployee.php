<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateEmployee extends Model
{
  use HasFactory;
  protected $guarded = [];


   public function member(){

    return $this->belongsTo(Member::class,'employee_id');
   }


  #scopes
  public function scopeOfCompany($query, $value)
  {
    return $query->where('company_id', $value);
  }


}
