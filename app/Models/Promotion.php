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
    'days_count',
    'is_active',
  ];
  protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    'is_active' => 'boolean',
    'days_count' => 'int'
  ];
  protected $table = 'promotions';
  protected $appends = ['left_days'];
  // protected $with = ['resolutions'];
  
public function getLeftDaysAttribute()
{
    $user = auth('api')->user();
    $usedCouponCodes = $user?->posts?->pluck('coupon_code')->toArray() ?? []; // الكوبونات اللي استخدمها المستخدم
    $leftDays = 0;

    foreach ($this?->where('discount', 100)->get() ?? [] as $promotion) {
        // لو المستخدم ما استخدمش الكوبون
        if (!in_array($promotion->name, $usedCouponCodes)) {
            if (!empty($promotion->days_count)) {
                $leftDays = $promotion->days_count;
            } elseif ($promotion->start_date && $promotion->end_date) {
                $start = \Carbon\Carbon::parse($promotion->start_date);
                $end = \Carbon\Carbon::parse($promotion->end_date);
                $leftDays = $end->diffInDays($start);
            }
        } else {
            // لو استخدمه، نحاول نحدد امتى استخدمه (مثلاً أول بوست بيحمل نفس الكوبون)
            $post = $user?->posts?->where('coupon_code', $promotion->name)->first();
            if ($post && $promotion->days_count) {
                $usedAt = \Carbon\Carbon::parse($post->created_at);
                $expiresAt = $usedAt->copy()->addDays($promotion->days_count);
                $now = \Carbon\Carbon::now();

                $leftDays = max(0, $expiresAt->diffInDays($now, false));
            } elseif ($promotion->start_date && $promotion->end_date) {
                $end = \Carbon\Carbon::parse($promotion->end_date);
                $now = \Carbon\Carbon::now();
                $leftDays = max(0, $end->diffInDays($now, false));
            }
        }

        // ممكن تكسر بعد أول كوبون أو تكمل لو عايز تجمع مثلاً
        break;
    }

    return $leftDays;
}


  #Relationshpis
  public function member()
  {
    return $this->belongsToMany(Member::class,'promotion_users', 'promotion_id', 'user_id');
  }

    public function resolutions()
    {
      // dd($this->resolutions());
      return $this->hasOne(PromotionResolution::class,'promotion_id','id');
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
