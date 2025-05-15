<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\{Follow,Member};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    public function add(Request $request)
    {
        
       $data = $request->validate([
           'followed_id'=>'required|exists:members,id',
       ]);

       $data['follower_id'] = auth('api')->user()->id;

        Follow::create($data);

       return response()->json(['message' => 'تم الاضافة بنجاح']);

    }

    public function Undo(Request $request)
    {
       $data = $request->validate([
           'followed_id'=>'required|exists:members,id',
       ]);

       auth('api')->user()->follower()?->where('followed_id', $data['followed_id'])->delete() ;

       return response()->json(['message' => 'تم الغاء المتابعة بنجاح']);

    }

    public function getFollowersMe()
    {
        return auth('api')->user()->followers()->paginate(10);
    }

    public function getFollowingMe()
    {
        return auth('api')->user()->followed()->paginate(10);
    }

    public function getFollowersUser(Member $member)
    {
        return $member->followers()->paginate(10);
    }


    public function getFollowingUser(Member $member)
    {
        return $member->followed()->paginate(10);
    }






    
}
