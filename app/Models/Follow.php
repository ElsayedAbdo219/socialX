<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Member::class, 'company_id');
    }

    public function follower()
    {
        return $this->belongsTo(Member::class, 'user_id');
    }
}
