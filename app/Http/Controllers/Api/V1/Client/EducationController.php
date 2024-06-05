<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Education;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EducationController extends Controller
{
    public function add(Request $request)
    {
       
           $data= $request->validate([
                'school' => 'required|string|max:255',
                'degree' => 'required|string|max:255',
                'field_of_study' => 'required|string|max:255',
                'grade' => 'required|string|max:255',
                'start_date' => 'required|string|max:255',
                'start_date_year' => 'required|string|max:255',
                'end_date' => 'required|string|max:255',
                'end_date_year' => 'required|string|max:255',
                'start_date_year' => 'string|string|max:255',
                'activities' => 'required|string',
                'description' => 'required|string',
            ]);

            $data['employee_id']=auth('api')->user()->id;
    
            $Education = Education::create($data);
    
            return response()->json(['message' =>'تم اضافة تفاصيل تعليمك بنجاح','Education'=>$Education]);
      

      
    }
}
