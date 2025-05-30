<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateCompany extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function employee(){

        return $this->belongsTo(Member::class,'employee_id');
       }
    
    
       public function member(){
    
        return $this->belongsTo(Member::class,'member_id');
       }
  #scopes
  public function scopeOfMember($query, $value)
  {
    return $query->where('member_id', $value);
  }


  public function scopeOfEmployee($query, $value)
  {
    return $query->where('employee_id', $value);
  }

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
}
