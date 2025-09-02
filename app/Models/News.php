<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable=['title', 'contentNews', 'title_en', 'contentNews_en', 'is_poll', 'ip', 'countries'];
    protected $casts = [
        'is_poll' => 'boolean',
        'countries' => 'array'
    ];

    # Relations
    public function poll()
    {
        return $this->hasMany(PollNews::class);
    }
       # Scopes
       public function scopeOfContent($query, $value)
       {
           if (empty($value)) return $query;
           return $query->where('contentNews', 'like', "%{$value}%")
           ->orWhere('title', 'like', "%{$value}%")
           ->orWhere('contentNews_en', 'like', "%{$value}%")
           ->orWhere('title_en', 'like', "%{$value}%");

       }
}