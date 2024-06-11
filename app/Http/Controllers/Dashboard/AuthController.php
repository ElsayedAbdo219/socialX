<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\Member;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enum\RegisterationRequestEnum;
use App\Http\Requests\Dashboard\LoginRequest;
use App\Models\Complain;

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
        $companies = Member::where('type',UserTypeEnum::COMPANY)->count();
        $employees = Member::where('type',UserTypeEnum::EMPLOYEE)->count();

        $activeCompanies = Member::where('is_Active' , 1)->where('type',UserTypeEnum::COMPANY)->count();
        $disactiveCompanies = Member::where('is_Active' , 0)->where('type',UserTypeEnum::COMPANY)->count();


        $activeEmployees = Member::where('is_Active' , 1)->where('type',UserTypeEnum::EMPLOYEE)->count();
        $disactiveEmployees = Member::where('is_Active' , 0)->where('type',UserTypeEnum::EMPLOYEE)->count();





        $jobs = Job::where('created_at', '=', Carbon::today())->count();

        $complains = Complain::where('created_at', '=', Carbon::today())->count();


        return view('dashboard.index',
        [
            'companies' => $companies ,
            'employees' => $employees ,

            'activeCompanies' => $activeCompanies ,
            'disactiveCompanies' => $disactiveCompanies ,

            'activeEmployees' => $activeEmployees ,
            'disactiveEmployees' => $disactiveEmployees ,



            'jobs' => $jobs ,
            'complains' => $complains ,



        ]
      
    
    );
    }

    

    public function login(Request $request)
    {
        $data=$request->validate([
         'email'=>'string|exists:users,email',
         'password'=>'string|max:10',
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

         return view('dashboard.profile.edit',
         [
            'user'=>$user
         ]
        
        );
    }
    
    


}
