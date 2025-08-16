<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Models\Member;
use App\Models\AdsPrice;
use App\Models\Promotion;
use App\Enum\PostTypeEnum;
use App\Enum\AdsStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;

class PostService
{
  # Advertise Post ##############
  public function addPostAdertise($request)
  {
    $dataValidatedChecked = $request->validated();
    $dataValidatedChecked['status']  = PostTypeEnum::ADVERTISE;
    $dataValidatedChecked['user_id']  = auth('api')->user()->id;
    $promotion =  '';
    if (!empty($dataValidatedChecked['coupon_code'])) {
      $promotion = Promotion::whereName($dataValidatedChecked['coupon_code'])->first();
    }
    unset($dataValidatedChecked['type']);
    unset($dataValidatedChecked['coupon_code']);

    \DB::beginTransaction();
    if (!empty($dataValidatedChecked['image'])) {
      $dataValidatedChecked['image'] = basename(Storage::disk('public')->put('posts', $dataValidatedChecked['image']));
      $adsPriceImage = AdsPrice::where('type', 'image')->select('price')->first();
      $dataValidatedChecked['price'] = $adsPriceImage->price;

    }
    
    if (!empty($dataValidatedChecked['file_name'])) {
      $filePath = 'posts/' . $dataValidatedChecked['file_name'];
      $fullPath = Storage::disk('public')->path($filePath); // مسار فعلي على السيرفر
   // if (!file_exists($dataValidatedChecked['fullPath'])) {
      $getID3 = new \getID3;
      $analysis = $getID3->analyze($fullPath);
      // dd($analysis);
      if (isset($analysis['playtime_seconds']) && $promotion && $analysis['playtime_seconds'] > $promotion->seconds) {
        return response()->json([
          'message' => 'مدة الفيديو يجب أن لا تتجاوز ' . $promotion->seconds . ' ثانية'
        ], 422);
      }
      $adsResolutionSecond = AdsPrice::where('resolution', $dataValidatedChecked['resolution'])->select('price')->first() ?? null;
      if(!empty($dataValidatedChecked['coupon_code'])){
        $dataValidatedChecked['price'] = $adsResolutionSecond->price * $analysis['playtime_seconds'] * $dataValidatedChecked['period']
         * ($dataValidatedChecked['coupon_code'] / 100);
      }else{
        $dataValidatedChecked['price'] = $adsResolutionSecond?->price * $analysis['playtime_seconds'] * $dataValidatedChecked['period'] ;
      }
      $dataValidatedChecked['file_name'] = basename($fullPath);
    }

    $post = Post::create($dataValidatedChecked);
    $post->adsStatus()->create([
      'status' => AdsStatusEnum::PENDING
    ]);
    # sending a notification to the user #  
    $notifabels = User::first();
    $notificationData = [
      'title' => " اضافة اعلان جديدة ",
      'body' => "تم اضافة اعلان جديد من شركة " . auth("api")->user()->full_name,
    ];

    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    \DB::commit();
    return response()->json(['message' => 'تم الاضافة بنجاح . انتظر 24 ساعة بعد تفعيل الاعلان'], 200);
  }
  # Normal Post ###################
  public function addPostNormal($request): JsonResponse
  {
    $dataValidatedChecked = $request->validated();
    $dataValidatedChecked['status']  = PostTypeEnum::NORMAL;
    $dataValidatedChecked['user_id']  = auth('api')->user()->id;
    unset($dataValidatedChecked['type']);
    \DB::beginTransaction();
    Post::create($dataValidatedChecked);
    # # # sending a notification to the user # # #  
    $notifiable = User::first();
    $notificationData = [
      'title' => 'اضافة منشور جديدة',
      'body' => 'تم اضافة منشور جديد من  ' . auth('api')->user()->full_name,
    ];

    \Illuminate\Support\Facades\Notification::send(
      $notifiable,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    \DB::commit();
    return response()->json(['message' => 'تم الاضافة بنجاح'], 200);
  }
  ### Advertise Post ##############
  public function updatePostAdertise($request, $Post_Id): JsonResponse
  {
    // dd($request->json());
    $dataValidatedChecked = $request->validated();
    $dataValidatedChecked['status']  = PostTypeEnum::ADVERTISE;
    $dataValidatedChecked['user_id']  = auth('api')->user()->id;
    $promotion =  '';
    if (!empty($dataValidatedChecked['coupon_code'])) {
      $promotion = Promotion::whereName($dataValidatedChecked['coupon_code'])->first();
    }
    unset($dataValidatedChecked['type']);
    unset($dataValidatedChecked['coupon_code']);
    $fullPath = '';
    if (!empty($dataValidatedChecked['image'])) {
      $dataValidatedChecked['image'] = basename(Storage::disk('public')->put('posts', $dataValidatedChecked['image']));
    }
    if (!empty($dataValidatedChecked['file_name'])) {
      $filePath = 'posts/' . $dataValidatedChecked['file_name'];
      $fullPath = Storage::disk('public')->path($filePath); // مسار فعلي على السيرفر

      if (file_exists($fullPath)) {
        $getID3 = new \getID3;
        $analysis = $getID3->analyze($fullPath);
        // dd($analysis);
        if (isset($analysis['playtime_seconds']) && $promotion && $analysis['playtime_seconds'] > $promotion->seconds) {
          return response()->json([
            'message' => 'مدة الفيديو يجب أن لا تتجاوز ' . $promotion->seconds . ' ثانية'
          ], 422);
        }
        $dataValidatedChecked['file_name'] = basename($fullPath);
      } else {
        return response()->json([
          'message' => 'الملف غير موجود'
        ], 404);
      }
    }

    $Post = Post::find($Post_Id);
    \DB::beginTransaction();
    if (isset($dataValidatedChecked['coupon_code']) && !empty($dataValidatedChecked['coupon_code'])) {
      $dataValidatedChecked['price'] = $dataValidatedChecked['price'] * ($dataValidatedChecked['coupon_code'] / 100);
    }
    $Post->update($dataValidatedChecked);
    # sending a notification to the user #  
    $notifabels = User::first();
    $notificationData = [
      'title' => " تحديث اعلان جديد ",
      'body' => "تم تحديث اعلان جديد من  " . auth("api")->user()->full_name,
    ];

    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    \DB::commit();
    return response()->json(['message' => 'تم تحديث الاعلان بنجاح '], 200);
  }
  # Normal Post ###################
  public function updatePostNormal($request, $Post_Id): JsonResponse
  {
    $dataValidatedChecked = $request->validated();
    $dataValidatedChecked['status']  = PostTypeEnum::NORMAL;
    $dataValidatedChecked['user_id']  = auth('api')->user()->id;
    unset($dataValidatedChecked['type']);
    $Post = Post::find($Post_Id);
    \DB::beginTransaction();
    $Post->update($dataValidatedChecked);
    // if ($request->hasFile('file_name')) {
    //   $fileName = basename(Storage::disk('public')->put('posts', file_get_contents($dataValidatedChecked['file_name'])));
    //   $Post->update(['file_name' => $fileName]);
    // }
    # # # sending a notification to the user # # #  
    $notifiable = User::first();
    $notificationData = [
      'title' => " تحديث منشور جديدة ",
      'body' => "تم تحديث المنشور من شركة " . auth("api")->user()->full_name,
    ];

    \Illuminate\Support\Facades\Notification::send(
      $notifiable,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    \DB::commit();
    return response()->json(['message' => 'تم تحديث المنشور بنجاح'], 200);
  }
}
