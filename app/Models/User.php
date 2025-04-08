<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\ModelTrait;
use App\Traits\Walletable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
// use Spatie\Permission\Traits\HasRoles;
use App\Models\Intro;
class User extends Authenticatable 
{
  
    use HasFactory;
    use Notifiable;
   
    use ModelTrait;

    protected $guarded = ['avatar'];

    protected array $filters = [
        'name',
        'id',
        'email',
       
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    # Scopes
    public function scopeOfName($query, $value)
    {
        if (empty($value)) return $query;
        return $query->where('name', 'like', "%$value%");
    }

    public function scopeOfId($query, $value): void
    {
        $value = is_array($value) ? $value : [$value];
        $query->whereIn('id', $value);
    }

    public function scopeOfEmail($query, $value): void
    {
        $query->where('email', 'like', "%$value%");
    }

    public function scopeOfMobile($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->where('mobile', 'like', "%$value%");
    }

    public function scopeOfStatus($query, $value)
    {
        if (($value == 'both' || empty($value)) && $value != 0) {
            return $query;
        }
        return $query->where('is_active', $value);
    }
}
