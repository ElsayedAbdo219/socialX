<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
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
        return view('dashboard.index');
    }

    

    public function login(Request $request)
    {
        $data=$request->validate([
         'email'=>'string|exists:users,email',
         'password'=>'string|max:8',
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


     public function edit()
    {
         return view('dashboard.edit');
    }
    
    


}
