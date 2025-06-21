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
            'time' => 'required|string|max:255'
       ]);

       $data['member_id'] = auth('api')->user()->id;

       Calender::create($data) ;
       return response()->json(['message' => 'تم الاضافة بنجاح']);

    }

    public function show(Request $request)
    {
       
      return  Calender::with('member')->OfUser(auth('api')->user()->id)
      ->when($request->query('search'), function ($query) use ($request) {
            $query->where('task', 'like', '%' . $request->search . '%');
        })
      ->orderByDesc('updated_at')->orderByDesc('created_at')->get() ;
        

    }

      public function update(Request $request,$calender)
    {
       $data = $request->validate([
            'task'=>'required|string',
            // 'time' => 'required|string|max:255'
       ]);

      // $data['member_id'] = auth('api')->user()->id;

      $Calender =  Calender::findOrFail($calender) ;

       $Calender?->update($data) ;
       return response()->json(['message' => 'تم تحديث المهمة  بنجاح']);

    }
    


    

    public function delete($task)
    {

       Calender::OfUser(auth('api')->user()->id)->where('id',$task)->delete() ;
       return response()->json(['message' => 'تم ازالة احدي مهامك بنجاح']);

    }


    public function changeStatus(Request $request,$calender)
    {
       $data = $request->validate([
            'status' => 'required|string',
       ]);

      $Calender =  Calender::findOrFail($calender) ;

       $Calender?->update($data) ;
       return response()->json(['message' => 'تم انهاء المهمة  بنجاح']);

    }

}