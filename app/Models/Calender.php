<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Calender extends Model
{
    use HasApiTokens,HasFactory,Notifiable;
    protected $guarded=[];

    #Relations
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }




      # Scopes
    public function scopeOfName($query, $value)
    {
        if (empty($value)) return $query;
        return $query->where('name', 'like', "%$value%");
    }


    # Scopes
    public function scopeOfUser($query, $value)
    {
        return $query->where('member_id',$value);
    }







    

}
