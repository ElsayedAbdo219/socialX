<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Models\Member;
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
  public function addPostAdertise($request): JsonResponse
  {
    $dataValidatedChecked = $request->validated();
    $dataValidatedChecked['status']  = PostTypeEnum::ADVERTISE;
    $dataValidatedChecked['user_id']  = auth('api')->user()->id;
    unset($dataValidatedChecked['type']);
    unset($dataValidatedChecked['coupon_code']);
    if (!empty($dataValidatedChecked['file_name'])) {
      // حفظ الملف
      $path = Storage::disk('public')->put('posts', $dataValidatedChecked['file_name']);
      $dataValidatedChecked['file_name'] = basename($path);
    }
    \DB::beginTransaction();
    if(isset($dataValidatedChecked['coupon_code']) && !empty($dataValidatedChecked['coupon_code'])) {
      $dataValidatedChecked['price'] = $dataValidatedChecked['price'] * ($dataValidatedChecked['coupon_code'] / 100);
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
    unset($dataValidatedChecked['type']);
    unset($dataValidatedChecked['coupon_code']);
    if (!empty($dataValidatedChecked['file_name'])) {
      $dataValidatedChecked['file_name'] = basename(Storage::disk('public')->put('posts', $dataValidatedChecked['file_name']));
    }
    $Post = Post::find($Post_Id);
    \DB::beginTransaction();
      if(isset($dataValidatedChecked['coupon_code']) && !empty($dataValidatedChecked['coupon_code'])) {
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
    if ($request->hasFile('file_name')) {
      $fileName = basename(Storage::disk('public')->put('posts', file_get_contents($dataValidatedChecked['file_name'])));
      $Post->update(['file_name' => $fileName]);
    }
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
