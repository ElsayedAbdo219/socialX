<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Enum\UserTypeEnum;

class EmployeeController extends Controller
{
    public function index(){
        return response()->json(Member::with(['rate','posts'])->where('type', UserTypeEnum::EMPLOYEE)->paginate(20));
    }


    public function getEmployeeData($employeeId){
      
            
           $member =  Member::where('id', $employeeId)->first();

           return $member->load(['experience','posts','skills','position','education','rateEmployeeTotal']);
    }



       

}
