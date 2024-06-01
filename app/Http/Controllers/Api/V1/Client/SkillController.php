<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function update(Request $request)
    {
       
           $data= $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
                'personal_photo' => 'string|image,mimes:jpeg,png,jpg',
                'personal_info' => 'string',
                'website' => 'string|url',
                'experience' => 'string',
                'coverletter' => 'image,mimes:jpeg,png,jpg',
            ]);
    
            $employee = Employee::findOrFail($id);
    
            $employee->update($data);
    
            return response()->json(['message' =>'Employee Updated Successfully','employee'=>$employee]);
      

      
    }
}
