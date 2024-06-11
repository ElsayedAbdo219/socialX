<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Enum\UserTypeEnum;
use App\Models\UserApplyJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserApplyJobController extends Controller
{

    public function add(Request $request)
    {
        $data = $request->validate([
            'jobs_applies_id' => 'required|exists:jobs_applies,id',
       //     'employee_id' => 'required|exists:employees,id,type,'.UserTypeEnum::EMPLOYEE,
        ]);
       // return auth('api')->user()->id;

        $data['employee_id'] = auth('api')->user()->id;

        UserApplyJob::create($data);

        return response()->json(['message' =>'تم اضافة  طلبك بنجاح']);


    }



}
