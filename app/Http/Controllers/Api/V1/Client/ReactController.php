<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Post;
use App\Models\React;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Notifications\ClientNotification;
use App\Http\Requests\Api\V1\Client\ReactRequest;

class ReactController extends Controller
{
  
  public function add(ReactRequest $request)
  {
    $requestDataValidated = $request->validated();
    $requestDataValidated['user_id'] = auth('api')->id();
    $recordExists = React::where('user_id', auth('api')->id())->where('post_id', $requestDataValidated['post_id'])->first();
    if ($recordExists) {
      $recordExists?->delete();
    }
    \DB::beginTransaction();
    React::create($requestDataValidated);
    # sending a notification to the user
    $postId = $request->post_id;
    $post = Post::where('id', $postId)->first();
    $notifabels = Member::where('id', $post->user_id)->first();
    $notificationData = [
      'title' => " تفاعل جديد علي منشور ",
      'body' => "  تم التفاعل علي منشورك من " . (
            auth('api')->user()->full_name
            ?? auth('api')->user()->first_name . ' ' . auth('api')->user()->last_name
        ),
         'type' => 'react_post',
        'id_link' => $request->post_id, 
    ];
    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    \DB::commit();
    return response()->json(['message' => 'تم اضافة تفاعلك علي المنشور بنجاح'], 200);
  }

  public function delete($React_Id): JsonResponse
  {
    React::whereId($React_Id)->delete();
    return response()->json(['message' => 'تم ازالة تفاعلك علي  المنشور بنجاح'], 200);
  }

  public function getReactsInfo(Request $request, $Post_Id): JsonResponse
  {
    $paginateSize = $request->query('paginateSize', 10);
    return response()->json(React::where('post_id', $Post_Id)->with('user')->paginate($paginateSize));
  }
}
