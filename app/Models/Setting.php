<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Setting extends Model
{
    use ModelTrait;

    protected $casts = [
        'value' => 'array',
    ];
    protected $guarded = [];

    public $filters = [
        'key'
    ];
    #getter
     protected function getImagePathAttribute()
    {
       if(!empty($this->value['imagePath']))
          return  asset('storage/'.$this->value['imagePath']);
          return null;
    } 
    # Scopes
    public function scopeOfKey($query, $value)
    {
        return $query->where('key', $value);
    }
}
