<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{
    public function add(Request $request)
    {
       
           $data= $request->validate([
                'position' => 'required|string|max:255',
                'company_id' => 'required',
            ]);
    
            $data['employee_id'] = auth('api')->user()->id;
    
            $Position = Position::create($data);
    
            return response()->json(['message' =>'تم اضافة منتصب بنجاح','Position'=>$Position]);
      

      
    }
}
