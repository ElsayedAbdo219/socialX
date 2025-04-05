<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Models\Post;
use App\Models\Member;
use App\Models\Review;
use App\Moedls\Position;
use App\Enum\UserTypeEnum;
use App\Models\Experience;
use App\Models\UserReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{

    public function addComment(Request $request, Post $Post)
    {
        if($Post->company->type == UserTypeEnum::EMPLOYEE )
        {
            $companies =  $Post->company->experience->pluck('company_id')->toArray();

            if (!in_array($Post->company_id, $companies)) {

             return response()->json(['message' => 'ليس لديك صلاحيات لأضافة تعليق على هذا المنشور']);

            }
         }
         
        $user_id =  auth('api')->user()->id;
       
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
