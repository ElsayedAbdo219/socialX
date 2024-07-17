<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Member;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ExperienceController extends Controller
{
    public function add(Request $request)
    {
       
        $data= $request->validate([
            'title' => 'required|string|max:255',
            'employment_type' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'location_type' => 'required|string|max:255',
            'status_works' => 'required|string|max:255|in:work,notWork',
            'start_date' => 'required|string|max:255',
            'start_date_year' => 'string|required|max:255',
            'end_date_year' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'profile_headline' => 'required|string|max:255',
            'skill' => 'required|string|max:255',
            'media' => 'image|mimes:jpeg,png,jpg',
        ]);

        $data['employee_id']=auth('api')->user()->id;

        $Experience =  Experience::create($data);

        if ($request->file('media')) {

            $media = uniqid() . '_' . $request->file('media')->getClientOriginalName();
  
            Storage::disk("local")->put($media, file_get_contents($request->file('media')));
  
  
            $Experience->update(
              [
  
              'media'=> $media,
  
              ]
        );
         
        }





        return response()->json(['message' =>'Experience Added Successfully','Experience'=>$Experience]);
      

      
    }


    public function get($member)

    {

        $member =  Member::where('id', $member)->first();
        
        return $member?->load('experience');


    }

    
}
