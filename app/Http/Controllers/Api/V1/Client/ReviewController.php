<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Models\Post;
use App\Models\Review;
use App\Moedls\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{

    public function add(Request $request , Post $Post){

        /* $initialVal=0; */
      $Post = Post::whereId($Post->id)->first();

      $PostwithReview = $Post->with(['review'])->first();
      
      if ($PostwithReview->review()->where('likes',1)->exists()) {

         return response()->json(['message' => 'لقد قمت بالأعجاب هذا المنشور من قبل']);

        }
        
        else{

            $Post->review()->create(
                [
                  'likes' => 1,
                  'comments' =>  $request->comments,
                  'member_id' => auth('api')->user()->id
                ]
                );
        
                return response()->json(['message' =>'تم اضافة تقييمك بنجاح']);
        }
     
    }
}
