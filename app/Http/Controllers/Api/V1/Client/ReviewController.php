<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Models\Post;
use App\Models\Review;
use App\Moedls\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Experience;

class ReviewController extends Controller
{

    public function addComment(Request $request, Post $Post)
    {
       
      /*   $Post = Post::whereId($Post->id)->first();
    
        $Post->load('review');
        
        foreach ($Post->review as $review) {
            if ($review->likes == 1) {
                return response()->json(['message' => 'لقد قمت بالأعجاب بهذا المنشور من قبل']);
            }
        }
        */

        $user_id =  auth('api')->user()->id;

        $experienceClient = Experience::pluck('company_id')->toArray();

        if (!in_array($user_id, $experienceClient)) {
            return response()->json(['message' => 'لا يمكنك تعليق هذا المنشور']);
        }        

        $Post->review()->create([
            'comments' => $request->comments,
            'member_id' => auth('api')->user()->id
        ]);
    
        return response()->json(
            [
                'message' => 'تم إضافة تعليك بنجاح',
                "data"   =>  $Post->load(['company', 'review', 'review.member'])
           ]

);
    }




    
    
    
}
