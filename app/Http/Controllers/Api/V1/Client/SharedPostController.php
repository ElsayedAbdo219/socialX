<?php
namespace App\Http\Controllers\Api\V1\Client;
use App\Models\SharedPost;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\V1\Client\SharedPostRequest;
use App\Notifications\ClientNotification;
use App\Models\Member;
class SharedPostController extends Controller {
  
  public function add(SharedPostRequest $request) 
  {
    $requestDataValidated = $request->validated();
    $Post = Post::where('id',$requestDataValidated['post_id'])->first();
    abort_if(auth('api')->id() == $Post->user_id, 403, 'غير مسموح بمشاركة منشورك');

    \DB::beginTransaction();
    $requestDataValidated['user_id'] = auth('api')->id();
    SharedPost::create($requestDataValidated);
    # sending a notification to the user
    $postId = $request->post_id;
    $post = Post::where('id', $postId)->first();
    $notifabels = Member::where('id',$post->user_id)->first();
    $notificationData = [
      'title' => " مشاركة منشور جديد ",
      'body' =>  "  تم مشاركة منشورك من " . (
            auth('api')->user()->full_name
            ?? auth('api')->user()->first_name . ' ' . auth('api')->user()->last_name
        ),
         'type' => 'shared_post',
        'id_link' => $request->post_id,   
    ];
    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    \DB::commit();
    return response()->json(['message' => 'تم مشاركة المنشور بنجاح' ],200);
  }

   public function update(Request $request,$sharedPost_Id) 
   {
    $sharedPost = SharedPost::find($sharedPost_Id);
    \DB::beginTransaction();
    $sharedPost->update(['comment' => $request->comment ?? $sharedPost->comment ]);
    # sending a notification to the user
    $postId = $request->post_id;
    $post = Post::where('id', $postId)->first();
    $notifabels = Member::where('id',$post->user_id)->first();
    $notificationData = [
      'title' => " مشاركة منشور جديد ",
      'body' =>  "  تم مشاركة منشورك من " . (
            auth('api')->user()->full_name
            ?? auth('api')->user()->first_name . ' ' . auth('api')->user()->last_name
        ),
         'type' => 'shared_post',
        'id_link' => $request->post_id, 
    ];
    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    \DB::commit();
    return response()->json(['message' => 'تم تحديث مشاركة المنشور بنجاح' ],200);
   }

  public function delete($sharedPost_Id) : JsonResponse
   {
    SharedPost::whereId($sharedPost_Id)->delete();
   return response()->json(['message' => 'تم حذف المنشور الذي تم مشاركته بنجاح'], 200);
   }

}






?>