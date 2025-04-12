<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\SharedPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\V1\Client\SharedPostRequest;
class SharedPostController extends Controller {
  
  public function add(SharedPostRequest $request) : JsonResponse
  {
    $requestDataValidated = $request->validated();
    $Post = Post::where('id',$requestDataValidated['post_id'])->first();
    abort_if(auth('api')->id() == $Post->user_id , 'غير مسموح بمشاركة منشورك');
    $requestDataValidated['user_id'] = auth('api')->id();
    SharedPost::create($requestDataValidated);
    return response()->json(['message' => 'تم مشاركة المنشور بنجاح' ],200);
  }

   public function update(Request $request,$sharedPost_Id) : JsonResponse
   {
    $sharedPost = SharedPost::find($sharedPost_Id);
    $sharedPost->update(['comment' => $request->comment ?? $sharedPost->comment ]);
    return response()->json(['message' => 'تم تحديث مشاركة المنشور بنجاح' ],200);
   }

  public function delete($sharedPost_Id) : JsonResponse
   {
    SharedPost::whereId($sharedPost_Id)->delete();
   return response()->json(['message' => 'تم حذف المنشور الذي تم مشاركته بنجاح'], 200);
   }

}






?>