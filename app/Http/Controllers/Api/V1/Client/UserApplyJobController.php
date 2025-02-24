<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Enum\UserTypeEnum;
use App\Models\{UserApplyJob,Job};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserApplyJobController extends Controller
{

    public function add(Request $request)
    {
        $data = $request->validate([
            'jobs_applies_id' => 'required|exists:jobs_applies,id',
        ]);
       // return auth('api')->user()->id;

        $data['employee_id'] = auth('api')->user()->id;

        if(auth('api')->user()->UserApplyJob()->where('jobs_applies_id',$data['jobs_applies_id'])->count() > 0){

            return response()->json(['message' =>'تم اضافة  طلبك من قبل']);
        }

        UserApplyJob::updateOrCreate($data);
    
        return response()->json(['message' =>'تم اضافة  طلبك بنجاح']);

    }



    public function getDetailsOfAppliers($idJob){

        return Job::Where('id',$idJob)->with(['jobAppliers','jobApplierMember','jobApplierMember.jobApplierIs','jobApplierMember.jobApplierIs'])->paginate(20) ?? [];
    
       }



}
