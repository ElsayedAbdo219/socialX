<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Models\Job;
use App\Models\User;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\ClientNotification;


class JobController extends Controller
{
    


    public function add(Request $request)
    {
       //   return $request->all();
        $data=$request->validate([
         
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


        $ss = [];

        foreach ($data['job_description'] as $job_desc) {
           
            $ss[] = $job_desc;
        }
        
        $data['job_description'] = $ss;

        
         $Job = Job::create($data);


          # sending a notification to the user   
        $notifabels = User::first();
        $notificationData = [
            'title' => " اضافة وظيفة جديدة ",
            'body' => "  تم اضافة وظيفة"  .$data['job_name'].' من '  . auth("api")->user()->full_name,
        ];

        \Illuminate\Support\Facades\Notification::send(
            $notifabels,
            new ClientNotification($notificationData, ['database', 'firebase'])
        );


         return response()->json(['message' =>'تم اضافة وظيفة  جديدة بنجاح', 'Job' => $Job]);

     
    }


   public function get(){

    return Job::with(['jobAppliers','jobApplierMember'])->paginate(20);

   }




   

}
