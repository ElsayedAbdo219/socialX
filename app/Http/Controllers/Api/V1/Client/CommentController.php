<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;
use App\Enum\PostTypeEnum;
use Illuminate\Http\JsonResponse;
use App\Services\PostService;
use App\Http\Requests\Api\V1\Client\CommentRequest;
class CommentController extends Controller {
  
  public function add(CommentRequest $request) : JsonResponse
  {
    $requestDataValidated = $request->validated();
    $requestDataValidated['user_id'] = auth('api')->id();
    Comment::create($requestDataValidated);
    return response()->json(['message' => 'تم النعليق علي المنشور بنجاح' ],200);
  }

   public function update(CommentRequest $request,$Comment_Id) : JsonResponse
   {
    $requestDataValidated = $request->validated();
    $requestDataValidated['user_id'] = auth('api')->id();
    $Comment = Comment::find($Comment_Id);
    $Comment->update($requestDataValidated);
    return response()->json(['message' => 'تم تحديث تعليقك علي المنشور بنجاح' ],200);
   }

  public function delete($Comment_Id) : JsonResponse
   {
    Comment::whereId($Comment_Id)->delete();
   return response()->json(['message' => 'تم حذف تعليقك بنجاح'], 200);
   }


}

?>