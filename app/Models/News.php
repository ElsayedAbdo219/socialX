<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $guarded=[];

       # Scopes
       public function scopeOfContent($query, $value)
       {
           if (empty($value)) return $query;
           return $query->where('contentNews', 'like', "%{$value}%");

       }
}
