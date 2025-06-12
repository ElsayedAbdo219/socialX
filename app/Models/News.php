<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $guarded=[];


    # Relations
    public function user()
    {
      return $this->belongsTo(Member::class,'user_id');
    }
       # Scopes
       public function scopeOfContent($query, $value)
       {
           if (empty($value)) return $query;
           return $query->where('contentNews', 'like', "%{$value}%");

       }
}
