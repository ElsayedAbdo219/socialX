<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Enum\UserTypeEnum;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $paginateSize = $request->query('paginateSize', 20);
        return response()->json(Member::with(['rate', 'posts'])->where('type', UserTypeEnum::EMPLOYEE)->paginate($paginateSize));
    }


    public function getMemberData($memberId)
    {

        $member =  Member::where('id', $memberId)->first();
        $exps = $member->experience;
        $totalExpYears = 0;
        foreach ($exps as $exp) {
            $startYear = $exp->start_date_year;
            $endYear = $exp->end_date_year ?? \Carbon\Carbon::now()->year;
            $totalExpYears += $endYear - $startYear;
        }
        return
            [
                'user' => $member->type === UserTypeEnum::COMPANY ? $member->load(['Intros', 'followersTotal', 'userCover', 'followedTotal', 'overview']) : $member->load(['followersTotal', 'followedTotal', 'userCover', 'Intros', 'skills', 'employeeOverview']),
                'totalPosts' => $member->posts()->count(),
                'currentCompany' =>   $member->type === UserTypeEnum::EMPLOYEE ?  $member->experience()->latest()->with('company')->first() : 'emp!',
                'expYearsNumbers' =>   $member->type === UserTypeEnum::EMPLOYEE ? $totalExpYears : 'emp!',
            ];
    }
}
