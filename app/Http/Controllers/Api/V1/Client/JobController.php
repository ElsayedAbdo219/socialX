<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Enum\UserTypeEnum;


class JobController extends Controller
{
    


    public function add(Request $request)
    {
       //   return $request->all();
        $data=$request->validate([

            'employee_id' => 'required|exists:members,id,type,' . UserTypeEnum::EMPLOYEE,
            'job_name' => 'required|string|max:255',

            'employee_type' => 'required|string|max:255',
            'job_period' => 'required|string|max:255',



            'overview' => 'required|string', // text 
            'job_category' => 'required|string|max:255',



            'job_description' => 'required|array', // array 
            'work_level' => 'required|string|max:255',


            'salary' => 'required|string|max:255',
            'salary_period' => 'required|string|max:255',


            'experience' => 'required|string|max:255',
           
      ]);
         //return $data;

         $data['member_id']=auth('api')->user()->id;

      //    $job_description= [];

      //    foreach($data['job_description'] as $item){

      //       $job_description[] = $item;
      //    }

      //   // $data['job_description'] = $job_description;
      //   $dataArray = explode(',', $data['job_description']);

      //     $data['job_description'] = $dataArray;

      // $serializedData = implode(',', $data['job_description']); // Serializ

      // $data['job_description']= $serializedData;

        // $data['job_description'] = $data['job_description'];


        $ss = [];

        foreach ($data['job_description'] as $job_desc) {
            // Assuming you want to use the job description as the key
            // If not, replace `$job_desc` with a different key
            $ss[] = $job_desc;
        }
        
        $data['job_description'] = $ss;
        
         $Job = Job::create($data);


         return response()->json(['message' =>'تم اضافة وظيفة  جديدة بنجاح', 'Job' => $Job]);

     
    }


   public function get(){

    return Job::paginate(20);



   }




}
