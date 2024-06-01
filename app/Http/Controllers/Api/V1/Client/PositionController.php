<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Position;
class PositionController extends Controller
{
    public function add(Request $request)
    {
       
           $data= $request->validate([
                'position' => 'required|string|max:255',
                'company_id' => 'required',
            ]);
    
            $data['employee_id']=auth()->user()->id;
    
            Position::create($data);
    
            return response()->json(['message' =>'Position Added Successfully','Position'=>$Position]);
      

      
    }
}
