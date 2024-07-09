<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Skill;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    public function add(Request $request)
    {
       
           $data= $request->validate([
                'skill' => 'required|string|max:255',
            ]);
    
            $data['employee_id'] = auth('api')->user()->id;
    
            $skill = Skill::create($data);
    
            return response()->json(['message' =>'تم اضافة مهارة جديدة بنجاح','skill'=>$skill]);
      
    }


    public function get($member)

    {

        $member =  Member::where('id', $member)->first();
        
        return $member->load('skills');


    }
}
