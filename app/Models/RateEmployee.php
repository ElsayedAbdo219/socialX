<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateEmployee extends Model
{
    use HasFactory;
    protected $guarded=[];


#scopes
 public function scopeOfEmployee($query,$value){
   return $query->where('company_id',$value);

}


}
