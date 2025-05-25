<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\UserReport;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\{DepositOperation, Trader,Member};
use App\Enum\{DepositTypeEnum, MoneyTypeEnum, UserTypeEnum};

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
    

   public function getAnalysis(Request $request, $companyId)
{
    $member = Member::findOrFail($companyId);
    $month = $request->query('month', date('m'));
    $year = $request->query('year', date('Y'));

    $postsQuery = $member->posts()
        ->when($month, fn($q) => $q->whereMonth('created_at', $month))
        ->when($year, fn($q) => $q->whereYear('created_at', $year));

    $total_react = (clone $postsQuery)->withCount('reacts')->get()->sum('reacts_count');
    $total_comments = (clone $postsQuery)->withCount('comments')->get()->sum('comments_count');
    $total_shares = (clone $postsQuery)->withCount('shares')->get()->sum('shares_count');
    $total_posts = $postsQuery->count(); 

    $total_followers = $member->follower()
        ->when($month, fn($q) => $q->whereMonth('created_at', $month))
        ->when($year, fn($q) => $q->whereYear('created_at', $year))
        ->count();

    $total_following = $member->followed()
        ->when($month, fn($q) => $q->whereMonth('created_at', $month))
        ->when($year, fn($q) => $q->whereYear('created_at', $year))
        ->count();

    return response()->json([
        'total_react' => $total_react,
        'total_comments' => $total_comments,
        'total_posts' => $total_posts,
        'total_shares' => $total_shares,
        'total_followers' => $total_followers,
        'total_following' => $total_following
    ]);
}



}