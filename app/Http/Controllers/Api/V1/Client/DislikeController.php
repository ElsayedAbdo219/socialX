<?php

namespace App\Http\Controllers\Api\V1\Client;

use Illuminate\Http\Request;

class DislikeController extends Controller
{
    public function addDisLike( Post $Post)
    {
       
        $Post->dislikes()->updateOrCreate(
            [
            
           
            'member_id' => auth('api')->user()->id
        ],
    [
        'dislikes' => 1,
    ]);
    

    return  $Post ;
     /*    return response()->json(['message' => 'تم إضافة اعجابك بنجاح']); */
    }
}
