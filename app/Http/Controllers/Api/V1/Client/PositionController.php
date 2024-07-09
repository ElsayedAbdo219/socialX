<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Member;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{
    public function add(Request $request)
    {
       
           $data= $request->validate([
                'position' => 'required|string|max:255',
                'company_id' => 'required|exists:members,id',
            ]);
    
            $data['employee_id'] = auth('api')->user()->id;
    
            $Position = Position::create($data);
    
            return response()->json(['message' =>'تم اضافة منتصب بنجاح','Position'=>$Position]);
      

      
    }


    public function get($member)

    {

        $member =  Member::where('id', $member)->first();
        
        return $member->load('position');


    }


}
