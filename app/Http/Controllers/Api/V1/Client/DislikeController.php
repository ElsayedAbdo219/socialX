<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
class DislikeController extends Controller
{
    public function addDisLike( Post $Post)
    {

        $postLiked = Like::where('post_id',$Post->id)->where('member_id',auth('api')->user()->id)->first(); 
       // return   $postLiked ;
        
        if ($postLiked ){
            $postLiked->delete() ;
          }

       
        $Post->dislikes()->updateOrCreate(
            [
            'member_id' => auth('api')->user()->id
        ],
    [
        'dislikes' => 1,
    ]);
    

    // return  $Post ;
        return response()->json(['message' => 'تم إضافة عدم اعجابك بنجاح',"data"   =>  $Post->load(['dislikes', 'dislikes.member'])]); 
    }
}
