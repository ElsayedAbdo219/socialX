<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'discount',
        'start_date',
        'end_date',
        'is_active',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];
    protected $table = 'promotions';
    #Scopes for filtering promotions
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }
    public function scopePast($query)
    {
        return $query->where('end_date', '<', now());
    }
    public function scopeDiscounted($query)
    {
        return $query->where('discount', '>', 0);
    }
    public function scopeofName($query, $searchTerm)
    {
        return $query->where('name', 'like', '%' . $searchTerm . '%');
    }
    public function scopeSortByDate($query, $direction = 'asc')
    {
        return $query->orderBy('start_date', $direction);
    }
    public function scopeSortByDiscount($query, $direction = 'desc')
    {
        return $query->orderBy('discount', $direction);
    }
}
