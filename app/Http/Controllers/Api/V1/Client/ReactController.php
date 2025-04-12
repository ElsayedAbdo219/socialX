<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Post;
use App\Models\User;
use App\Models\React;
use App\Models\Intro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;
use App\Enum\PostTypeEnum;
use Illuminate\Http\JsonResponse;
use App\Services\PostService;
use App\Http\Requests\Api\V1\Client\ReactRequest;

class ReactController extends Controller {
  
  public function add(ReactRequest $request) : JsonResponse
  {
    $requestDataValidated = $request->validated();
    $requestDataValidated['user_id'] = auth('api')->id();
    React::create($requestDataValidated);
    return response()->json(['message' => 'تم اضافة تفاعلك علي المنشور بنجاح' ],200);
  }

  public function delete($React_Id) : JsonResponse
   {
    React::whereId($React_Id)->delete();
   return response()->json(['message' => 'تم ازالة تفاعلك علي  المنشور بنجاح'], 200);
   }

   public function getReactsInfo($Post_Id)
   {

     $Post = Post::find($Post_Id);
     return $Post->reacts()->paginate(10);
    }

}

?>