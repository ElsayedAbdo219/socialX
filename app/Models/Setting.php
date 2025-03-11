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

         // #getter
         public function getValueAttribute($value)
         {
             $decodedValue = json_decode($value, true);
         
             // إذا لم يكن مصفوفة، نرجع مصفوفة فارغة
             if (!is_array($decodedValue)) {
                 return [];
             }
         
             // استخراج القيم النصية (ar & en) مع التحقق
             $result = [
                 'ar' => is_string($decodedValue['ar'] ?? '') 
                     ? strip_tags($decodedValue['ar']) 
                     : $decodedValue['ar'],
         
                 'en' => is_string($decodedValue['en'] ?? '') 
                     ? strip_tags($decodedValue['en']) 
                     : $decodedValue['en'],
             ];
         
             // إضافة أي بيانات أخرى في `value` مثل `imagePath`
             foreach ($decodedValue as $key => $val) {
                 if (!in_array($key, ['ar', 'en'])) {
                     $result[$key] = $val; // أضف باقي البيانات كما هي بدون تغيير
                 }
             }
         
             return $result;
         }
          
        
    # Scopes
    public function scopeOfKey($query, $value)
    {
        return $query->where('key', $value);
    }
}
