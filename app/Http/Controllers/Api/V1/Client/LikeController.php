<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function addLike(Post $Post)
    {
       
        $postliked = auth('api')->user()->posts()->whereHas('likes', function($query) use ($Post) {
            $query->where('post_id', $Post->id);
        })->exists();
        
        if ($postliked ){
            $postliked->destroy();    
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
    
        return response()->json(['message' => 'تم إضافة اعجابك بنجاح']);
    }
    
}
