<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Moedls\Position;

class ReviewController extends Controller
{
    public function add(Request $request){

        $data= $request->validate([
            'position' => 'required|string|max:255',
            'post_id' => 'required|string|max:255',
            'likes' => 'required',
            'comments' => 'string',
            
        ]);

        $data['employee_id']=auth()->user()->id;

        Position::create($data);

        return response()->json(['message' =>'Position Added Successfully','Position'=>$Position]);
    }
}
