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

class User extends Authenticatable implements HasMedia
{
  
    use HasFactory;
    use Notifiable;
    use InteractsWithMedia;
   
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
        'last_login' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['thumbnail'];


    public function isActive(): bool
    {
        return $this->is_active ?? 1;
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($this->getFirstMediaUrl('avatar') != '' ? $this->getFirstMediaUrl('avatar') : asset('assets/avatar.jpeg')),
        );
    }

    public function getThumbnailAttribute()
    {
        return $this->getFirstMediaUrl('avatar') != '' ? $this->getFirstMediaUrl('avatar') : asset('assets/avatar.jpeg');
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => (Hash::make($value)),
        );
    }






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
