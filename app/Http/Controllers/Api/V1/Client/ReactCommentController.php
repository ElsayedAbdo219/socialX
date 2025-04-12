<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\ReactComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\V1\Client\ReactCommentRequest;
class ReactCommentController extends Controller {
  
  public function add(ReactCommentRequest $request) : JsonResponse
  {
    $requestDataValidated = $request->validated();
    $requestDataValidated['user_id'] = auth('api')->id();
    ReactComment::create($requestDataValidated);
    return response()->json(['message' => 'تم اضافة تفاعلك علي التعليق بنجاح' ],200);
  }

  public function delete($ReactComment_Id) : JsonResponse
   {
    ReactComment::whereId($ReactComment_Id)->delete();
   return response()->json(['message' => 'تم ازالة تفاعلك علي  التعليق بنجاح'], 200);
   }

}

?>