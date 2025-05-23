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


    public function getMemberData($memberId){

           $member =  Member::where('id', $memberId)->first();
           return $member->type === UserTypeEnum::COMPANY ? $member->load(['Intros','followersTotal','userCover','followedTotal','overview']) : $member->load(['followersTotal','followedTotal','userCover','Intros','skills','employeeOverview']);
    }



       

}
