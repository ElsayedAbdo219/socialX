<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Member;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Notifications\ClientNotification;
use App\Http\Requests\Api\V1\Client\CommentRequest;

class CommentController extends Controller
{

  public function add(CommentRequest $request)
  {
    $requestDataValidated = $request->validated();
    \DB::beginTransaction();
    $requestDataValidated['user_id'] = auth('api')->id();
    Comment::create($requestDataValidated);
    # sending a notification to the user
    $postId = $request->post_id;
    $post = Post::where('id', $postId)->first();
    $notifabels = Member::where('id', $post->user_id)->first();
    $notificationData = [
      'title' => " تعليق جديد علي منشور ",
      'body' => "تم التعليق علي منشورك من " . (
        auth('api')->user()->full_name
        ?? auth('api')->user()->first_name . ' ' . auth('api')->user()->last_name
      ),

    ];
    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    \DB::commit();
    return response()->json(['message' => 'تم النعليق علي المنشور بنجاح'], 200);
  }

  public function update(CommentRequest $request, $Comment_Id): JsonResponse
  {
    $requestDataValidated = $request->validated();
    $requestDataValidated['user_id'] = auth('api')->id();
    $Comment = Comment::find($Comment_Id);
    \DB::beginTransaction();
    $Comment->update($requestDataValidated);
    # sending a notification to the user
    $postId = $Comment->post_id;
    $post = Post::where('id', $postId)->first();
    $notifabels = Member::where('id', $post->user_id)->first();
    $notificationData = [
      'title' => " تعليق جديد علي منشور ",
      'body' =>  "  تم التعليق علي منشورك من " . auth("api")->user()->full_name,
    ];
    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    \DB::commit();
    return response()->json(['message' => 'تم تحديث تعليقك علي المنشور بنجاح'], 200);
  }

  public function delete($Comment_Id): JsonResponse
  {
    Comment::whereId($Comment_Id)->delete();
    return response()->json(['message' => 'تم حذف تعليقك بنجاح'], 200);
  }
}
