<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
class DislikeController extends Controller
{
    public function addDisLike( Post $Post)
    {

        $hasDisliked = auth('api')->user()->posts()->whereHas('dislikes', function($query) use ($Post) {
            $query->where('post_id', $Post->id);
        })->exists();
        
        if ($postDisLiked ){
            $postDisLiked->destroy();    
          }

       
        $Post->dislikes()->updateOrCreate(
            [
            'member_id' => auth('api')->user()->id
        ],
    [
        'dislikes' => 1,
    ]);
    

    // return  $Post ;
        return response()->json(['message' => 'تم إضافة اعجابك بنجاح']); 
    }
}
