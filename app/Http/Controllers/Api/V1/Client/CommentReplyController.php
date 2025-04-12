<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Models\CommentReply;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\V1\Client\ReplyCommentRequest;
class CommentReplyController extends Controller {
  
  public function add(ReplyCommentRequest $request) : JsonResponse
  {
    $requestDataValidated = $request->validated();
    $requestDataValidated['user_id'] = auth('api')->id();
    CommentReply::create($requestDataValidated);
    return response()->json(['message' => 'تم الرد علي التعليق  بنجاح' ],200);
  }

   public function update(ReplyCommentRequest $request,$CommentReply_Id) : JsonResponse
   {
    $requestDataValidated = $request->validated();
    $requestDataValidated['user_id'] = auth('api')->id();
    $CommentReply = CommentReply::find($CommentReply_Id);
    $CommentReply->update($requestDataValidated);
    return response()->json(['message' => 'تم تحديث تعليقك  بنجاح' ],200);
   }

  public function delete($CommentReply_Id) : JsonResponse
   {
    CommentReply::whereId($CommentReply_Id)->delete();
   return response()->json(['message' => 'تم حذف  تعليقك  بنجاح'], 200);
   }


}

?>