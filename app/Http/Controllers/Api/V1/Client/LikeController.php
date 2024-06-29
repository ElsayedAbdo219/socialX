<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function addLike( Post $Post)
    {
       
        $Post->likes()->updateOrCreate(
            [
            
           
            'member_id' => auth('api')->user()->id
        ],
    [
        'likes' => 1,
    ]);
    

    return  $Post ;
     /*    return response()->json(['message' => 'تم إضافة اعجابك بنجاح']); */
    }
}
