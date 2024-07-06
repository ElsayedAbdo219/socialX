<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Post;
use App\Models\Dislike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function addLike(Post $Post)
    {
       
        $postDisLiked = Dislike::where('post_id',$Post->id)->where('member_id',auth('api')->user()->id)->first(); 

if ($postDisLiked) {
    $postDisLiked->delete(); // Delete the model instance if it exists
}

        $Post->likes()->updateOrCreate(
            [
                'member_id' => auth('api')->user()->id,
                'post_id' => $Post->id, // Ensure you have the necessary fields for the unique key
            ],
            [
                'likes' => 1,
            ]
        );
    
        return response()->json(['message' => 'تم إضافة اعجابك بنجاح',  "data"   =>  $Post->load(['likes', 'likes.member']) ]);
    }
    
}
