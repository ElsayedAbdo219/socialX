<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\Post;
use App\Models\User;
use App\Models\Member;
use App\Models\Complain;
use App\Enum\UserTypeEnum;
use App\Charts\SampleChart;
use App\Models\UserApplyJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enum\RegisterationRequestEnum;
use App\Http\Requests\Dashboard\LoginRequest;

class AuthController extends Controller
{

  public function index()
  {
    return view('dashboard.auth-login');
  }


  public function loginASview()
  {
    return view('dashboard.auth-login');
  }

  public function home()
  {
    $members = Member::count();
    $companies = Member::where('type', UserTypeEnum::COMPANY)->count();
    $employees = Member::where('type', UserTypeEnum::EMPLOYEE)->count();

    $activeCompanies = Member::where('is_Active', 1)->where('type', UserTypeEnum::COMPANY)->count();
    $disactiveCompanies = Member::where('is_Active', 0)->where('type', UserTypeEnum::COMPANY)->count();
    $activeEmployees = Member::where('is_Active', 1)->where('type', UserTypeEnum::EMPLOYEE)->count();
    $disactiveEmployees = Member::where('is_Active', 0)->where('type', UserTypeEnum::EMPLOYEE)->count();
    $jobs = Job::whereDate('created_at', Carbon::today())->count();
    $all_jobs = Job::count();
    $jobs_appliers = UserApplyJob::count();
    $allPosts = Post::where('status', '!=', 'advertise')->count();
    $dailyAdvertises = Post::where('status', 'advertise')
      ->whereDate('created_at', Carbon::today())
      ->count();
      $Advertises = Post::where('status', 'advertise')
      ->count();
  // return [$Advertises ,$allPosts ];
    // start chat js script
    // $chart = new SampleChart;
    // $chart->labels(['One', 'Two', 'Three', 'Four']);
    // $chart->dataset('My dataset', 'line', [1, 2, 3, 4]);


    //   $data = [
    //     'labels' => ['عدد الوظائف', 'عدد المتقدمين'],
    //     'data' => [$all_jobs, $jobs_appliers]
    // ];

    $chart = app()->chartjs
      ->name('pieChartjobs')
      ->type('pie')
      ->size(['width' => 400, 'height' => 200])
      ->labels([__('dashboard.number_of_jobs'), __('dashboard.number_of_appliers')])
      ->datasets([
        [
          'backgroundColor' => ['#FF6384', '#36A2EB'],
          'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
          'data' => [$all_jobs, $jobs_appliers]
        ]
      ])
      ->options([]);

    $chartPosts = app()->chartjs
      ->name('pieChartPosts')
      ->type('pie')
      ->size(['width' => 400, 'height' => 200])
      ->labels([__('dashboard.number_of_posts'), __('dashboard.number_of_advertises')])
      ->datasets([
        [
          'backgroundColor' => ['#4E79A7', '#F28E2B', '#E15759', '#76B7B2'], // 4 ألوان
        'hoverBackgroundColor' => ['#4E79A7', '#F28E2B', '#E15759', '#76B7B2'],
        'data' => [$allPosts, $Advertises] 
        ]

      ])
      ->options([]);

    // End chat js script


    return view(
      'dashboard.index',
      [
        'members' => $members,
        'companies' => $companies,
        'employees' => $employees,
        'activeCompanies' => $activeCompanies,
        'disactiveCompanies' => $disactiveCompanies,
        'activeEmployees' => $activeEmployees,
        'disactiveEmployees' => $disactiveEmployees,
        'jobs' => $jobs,
        'Advertises' => $Advertises,
        'all_jobs' => $all_jobs,
        'chart' => $chart,
        'chartPosts' => $chartPosts,
        'dailyAdvertises' => $dailyAdvertises,
      ]
    );
  }



  public function login(Request $request)
  {
    $data = $request->validate([
      'email' => 'string|exists:users,email',
      'password' => 'string|max:10',
    ]);
    if (auth('web')->attempt($data)) {
      session()->regenerate();
      return redirect()->route('admin.home');
    }
    return back()->with(['error' => "البريد الالكتروني او كلمة المرور خطأ"]);
  }

  public function logout()
  {
    Auth::logout();
    return redirect()->route('admin.login');
  }




  public function markered(Request $request)
  {
    $request->user()->unreadNotifications->markAsRead();
    return redirect()->route('admin.home');
  }


  public function edit(User  $user)
  {

    return view(
      'dashboard.profile.edit',
      [
        'user' => $user
      ]

    );
  }
}
