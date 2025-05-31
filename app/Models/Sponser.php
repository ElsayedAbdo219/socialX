<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'image',
        'days_number',
        'price',
        'status', // pending, approved, rejected
        'payment_status', // unpaid, paid
    ];
    protected $casts = [
        'days_number' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function company()
    {
        return $this->belongsTo(Member::class, 'user_id');
    }


    public function scopeOfName($query, $name)
    {
        return $query->whereHas('company', function ($q) use ($name) {
            $q->where('full_name', 'like', "%{$name}%");
        });
    }
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
