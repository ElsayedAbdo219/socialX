<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\UserReport;
use Illuminate\Http\Request;
use App\Enum\OperationTypeEnum;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\{DepositOperation, Trader,Member};
use App\Enum\{DepositTypeEnum, MoneyTypeEnum, UserTypeEnum};
use App\Http\Resources\Api\V1\Client\{TraderResource, DepositOperationResource};

class CompanyController extends Controller
{

    use ApiResponseTrait;



     public function index(Request $request){
        $paginateSize = $request->query('paginateSize', 20);
        $companyName = $request->query('companyName');
        return response()->json(Member::where('type', UserTypeEnum::COMPANY)->when($companyName, fn($query) =>
            $query->where('full_name', 'like', "%{$companyName}%")
        )->with('posts','followersTotal','rateCompany','rateCompanyTotal','follower')->paginate($paginateSize));
    }

    public function indexofEmployee(Request $request){
        $paginateSize = $request->input('paginateSize', 20);
        return response()->json(Member::where('type', UserTypeEnum::EMPLOYEE)->with('posts','experience','followersTotal','skills','position','education','rateEmployee','rateEmployeeTotal','follower')->paginate($paginateSize));
    }

     public function getJobs($id, Request $request){
        $paginateSize = $request->input('paginateSize', 10);
        return Member::where('id',$id)->with('jobs')->paginate($paginateSize);
    }
    

    public function getAnalysis($companyId)
    {
       $member = Member::findOrfail($companyId);
       

    }


}