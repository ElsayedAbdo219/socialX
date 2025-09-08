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
   
           $result = [];
   
           // التحقق من وجود 'ar' وكونه نصًا قبل المعالجة
           if (!empty($decodedValue['ar']) && is_string($decodedValue['ar']) ) {
               $trimmedAr = trim($decodedValue['ar']);
   
               if (preg_match('/^<[^>]+>.*<\/[^>]+>$/s', $trimmedAr)) {
                   $result['ar'] = strip_tags($trimmedAr);
               } else {
                   $result['ar'] = $trimmedAr;
               }
           }else{
               $result['ar'] = isset($decodedValue['ar']) ? $decodedValue['ar'] : '';
           }
   
           // التحقق من وجود 'en' وكونه نصًا قبل المعالجة
           if (!empty($decodedValue['en']) && is_string($decodedValue['en'])  ) {
               $trimmedEn = trim($decodedValue['en']);
   
               if (preg_match('/^<[^>]+>.*<\/[^>]+>$/s', $trimmedEn)) {
                   $result['en'] = strip_tags($trimmedEn);
               } else {
                   $result['en'] = $trimmedEn;
               }
           }else{
               $result['en'] = isset($decodedValue['en']) ? $decodedValue['en'] : '';
           }
   
           // إضافة أي بيانات أخرى في `value` مثل `imagePath`
           foreach ($decodedValue as $key => $val) {
               if (!in_array($key, ['ar', 'en'])) {
                   $result[$key] = $val; // أضف باقي البيانات كما هي بدون تغيير
               }
           }
   
           return $result;
       }
// #getter
// public function getValueAttribute($value)
// {
//     $decodedValue = json_decode($value, true);

//     // إذا لم يكن مصفوفة، نرجع مصفوفة فارغة
//     if (!is_array($decodedValue)) {
//         return [];
//     }

//     $result = [];

//     // التحقق من وجود 'ar' وكونه نصًا قبل المعالجة
//     if (!empty($decodedValue['ar']) && is_string($decodedValue['ar']) ) {
//         $trimmedAr = trim($decodedValue['ar']);

//         if (preg_match('/^<[^>]+>.*<\/[^>]+>$/s', $trimmedAr)) {
//             $result['ar'] = strip_tags($trimmedAr);
//         } else {
//             $result['ar'] = $trimmedAr;
//         }
//     }else{
//         $result['ar'] = $decodedValue['ar'];
//     }

//     // التحقق من وجود 'en' وكونه نصًا قبل المعالجة
//     if (!empty($decodedValue['en']) && is_string($decodedValue['en'])  ) {
//         $trimmedEn = trim($decodedValue['en']);

//         if (preg_match('/^<[^>]+>.*<\/[^>]+>$/s', $trimmedEn)) {
//             $result['en'] = strip_tags($trimmedEn);
//         } else {
//             $result['en'] = $trimmedEn;
//         }
//     }else{
//         $result['en'] = $decodedValue['en'];
//     }

//     // إضافة أي بيانات أخرى في `value` مثل `imagePath`
//     foreach ($decodedValue as $key => $val) {
//         if (!in_array($key, ['ar', 'en'])) {
//             $result[$key] = $val; // أضف باقي البيانات كما هي بدون تغيير
//         }
//     }

//     return $result;
// }


          
        
    # Scopes
    public function scopeOfKey($query, $value)
    {
        return $query->where('key', $value);
    }
}
