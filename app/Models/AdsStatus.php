<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'ads_id',
        'status',
        'reason_cancelled',
    ];
    protected $casts = [
        'ads_id' => 'integer',
        'status' => 'string',
        'reason_cancelled' => 'string',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'ads_id');
    }
 
}
