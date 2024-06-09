<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Follow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    public function store(Request $request)
    {
       $data = $request->validate([
           'follwor_id'=>'required|exists:members,id',
       ]);

       $data['follower_id'] = auth('api')->user()->id;

       Follow::craete($data);

       return response()->json(['message' => 'تم الاضافة بنجاح']);
    }
}
