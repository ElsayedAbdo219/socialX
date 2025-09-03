<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    'discount',
    'start_date',
    'end_date',
    'days_count',
    'is_active',
    'seconds', 
  ];
  protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    'is_active' => 'boolean',
    'days_count' => 'int',
    'seconds' => 'int',
  ];
  protected $table = 'promotions';
  protected $appends = ['left_days','free_six_months'];
  // protected $with = ['resolutions'];
  public function getFreeSixMonthsAttribute()
  {
    if($this->name == 'free')
      return true;
      return false; 
  }



  public function getCreatedAtAttribute($value)
  {
    return Carbon::parse($value)->format('Y-m-d');
  }

  public function getUpdatedAtAttribute($value)
  {
    return Carbon::parse($value)->format('Y-m-d');
  }
    public function getStartDateAttribute($value)
  {
    if(!empty($value))
    return Carbon::parse($value)->format('Y-m-d');
    return null; 
  }

  public function getEndDateAttribute($value)
  {
    if(!empty($value))
    return Carbon::parse($value)->format('Y-m-d');
    return null; 

  }


public function getLeftDaysAttribute()
{
    $user = auth('api')->user();

    if (!$user) {
        return 0;
    }

    $post = $user?->posts?->where('coupon_code', $this->name)->first() ;
    if ($post) {
        if ($this->days_count) {
            $usedAt = \Carbon\Carbon::parse($post->created_at);
            $expiresAt = $usedAt->copy()->addDays($this->days_count);
            return max(0, $expiresAt->diffInDays(now(), false));
        } elseif ($this->start_date && $this->end_date) {
            $end = \Carbon\Carbon::parse($this->end_date);
            return max(0, $end->diffInDays(now(), false));
        }
    } else {
        if ($this->days_count) {
            // dd(Carbon::today(),$this->days_count);
            Log::info('Current Time: ' . Carbon::now());
            $differenceBetweenDates = Carbon::now()->diffInDays($this->created_at);
            return $this->days_count - $differenceBetweenDates;
        } elseif ($this->start_date && $this->end_date) {
            $now = now();
            $start = \Carbon\Carbon::parse($this->start_date);
            $end = \Carbon\Carbon::parse($this->end_date);

            if ($now->lt($start)) {
                return $start->diffInDays($end);
            } elseif ($now->between($start, $end)) {
                return $end->diffInDays($now);
            } else {
                return 0;
            }
        }
    }

    return 0;
}




  #Relationshpis
  public function member()
  {
    return $this->belongsToMany(Member::class, 'promotion_users', 'promotion_id', 'user_id');
  }

  public function resolutions()
  {
    // dd($this->resolutions());
    return $this->hasOne(PromotionResolution::class, 'promotion_id', 'id');
  }

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
  public function scopeofDiscount($query,$value)
  {
    return $query->where('discount', '=', $value);
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
