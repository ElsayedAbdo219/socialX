<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Enum\UserTypeEnum;

class EmployeeController extends Controller
{
    public function index(Request $request){
        $paginateSize = $request->query('paginateSize', 20);
        return response()->json(Member::with(['rate','posts'])->where('type', UserTypeEnum::EMPLOYEE)->paginate($paginateSize));
    }


    public function getEmployeeData($employeeId){
      
            
           $member =  Member::where('id', $employeeId)->first();

           return $member->load(['experience','posts','skills','position','education','rateEmployeeTotal']);
    }



       

}
