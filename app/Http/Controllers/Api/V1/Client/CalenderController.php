<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Calender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalenderController extends Controller
{
    public function add(Request $request)
    {
       $data = $request->validate([
            'task'=>'required|string',
            'time' => 'string|max:255'
       ]);

       $data['member_id'] = auth('api')->user()->id;

       Calender::create($data) ;
       return response()->json(['message' => 'تم الاضافة بنجاح']);

    }


    public function delete($task)
    {

       Calender::where('id',$task)->delete() ;
       return response()->json(['message' => 'تم ازالة احدي مهامك بنجاح']);

    }




}