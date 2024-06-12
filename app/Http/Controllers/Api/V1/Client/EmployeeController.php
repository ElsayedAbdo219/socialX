<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Enum\UserTypeEnum;

class EmployeeController extends Controller
{
    public function index(){
        return response()->json(Member::with(['rate'])->where('is_Active', '1')->where('type', UserTypeEnum::EMPLOYEE)->paginate(20));
    }
       

}
