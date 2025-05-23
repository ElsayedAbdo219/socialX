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

    public function getFollowersMe(Request $request)
    {
        $paginateSize = $request->query('paginateSize', 10);
        return Follow::where('followed_id',auth('api')->id())->with('userfollower')->paginate($paginateSize);
    }

    public function getFollowingMe(Request $request)
    {
        $paginateSize = $request->query('paginateSize', 10);
        return Follow::where('follower_id',auth('api')->id())->with('userfollowed')->paginate($paginateSize);
    }

    public function getFollowersUser($member, Request $request)
    {
        $paginateSize = $request->query('paginateSize', 10);
        return Follow::where('followed_id',$member)->with('userfollower')->paginate($paginateSize);
    }


    public function getFollowingUser($member, Request $request)
    {
        $paginateSize = $request->query('paginateSize', 10);
        return Follow::where('follower_id',$member)->with('userfollowed')->paginate($paginateSize);
    }






}
