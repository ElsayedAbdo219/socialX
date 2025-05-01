<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateEmployee extends Model
{
  use HasFactory;
  protected $guarded = [];


   public function employee(){

    return $this->belongsTo(Member::class,'employee_id');
   }


   public function company(){

    return $this->belongsTo(Member::class,'company_id');
   }


  #scopes
  public function scopeOfCompany($query, $value)
  {
    return $query->where('company_id', $value);
  }


  public function scopeOfEmployee($query, $value)
  {
    return $query->where('employee_id', $value);
  }

}
