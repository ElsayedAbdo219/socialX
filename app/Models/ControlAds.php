<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlAds extends Model
{
    use HasFactory;
    protected $fillable = ['ads_id','play_on'];
    # Relation (s)
    # Relation with Post (Ad)
    public function ad()
    {
        return $this->belongsTo(Post::class, 'ads_id');
    }
}
