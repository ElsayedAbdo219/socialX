<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Education;
class EducationController extends Controller
{
    public function add(Request $request)
    {
       
           $data= $request->validate([
                'title' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'employment_type' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'location_type' => 'required|string|max:255',
                'status_works' => 'required|string|max:255',
                'start_date' => 'required|string|max:255',
                'start_date_year' => 'string|url',
                'end_date_year' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'profile_headline' => 'required|string|max:255',
                'skill' => 'required|string|max:255',
                'media' => 'image,mimes:jpeg,png,jpg',
            ]);

            $data['employee_id']=auth()->user()->id;
    
            Education::create($data);
    
            return response()->json(['message' =>'Education Added Successfully','Education'=>$Education]);
      

      
    }
}
