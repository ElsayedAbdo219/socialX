<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserTypeEnum;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    Employee,
    Company,
    User
};

use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Notification;


class AuthCompanyController extends Controller
{
    public function register(Request $request)
    {
            $data=$request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
                'logo' => 'image,mimes:jpeg,png,jpg',
                'slogo' => 'string',
                'website' => 'url|string',
                'address' => 'string',
                'bio' => 'string',
     ]);
    
            $company = Company::create([$data]);
    
           return response()->json(['message' =>'Employee Updated Successfully','company'=>$company]);
      
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:companies',
            'password' => 'required',
        ]);


        $Companies=Company::pluck('email')->toArray();
       
        $Company=Company::whereEmail($request->email)->first(); 

        if (!in_array($Company,$Companies) && $request->password!=$Company?->password) {

           throw ValidationException::withMessages([

               'email' => ['The provided credentials are incorrect.'],

           ]);

        }

    $token = $Company->createToken('api_token')->plainTextToken;

    return response()->json(['token' => $token,'company'=>$Company]);

    }



    public function logout(Request $request)
    {
       
        $user = Auth::user();

        $user->tokens()->where('name', 'auth_token')->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function update(Request $request)
    {

            $data=$request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
                'logo' => 'image,mimes:jpeg,png,jpg',
                'slogo' => 'string',
                'website' => 'url|string',
                'address' => 'string',
                'bio' => 'string',
              
            ]);
    
            $company = Company::findOrFail($id);
    
            $company->update($data);
    
            return response()->json(['message' =>'Company Updated Successfully','company'=>$company]);
      
    }

    
     public function deleteMyAccount(){
        Company::whereId(auth()->user()->id)->destroy();
        return response()->json(['message' =>'Company Deleted Successfully']);
     }


      public function verifyOtp(){

        $codeRandom=rand(9999,10000);
         
       // Mail::send(class name , $codeRandom in constructed);

        return response()->json(['message' =>'Email Sended To '. auth()->user()->name .' Successfully']);
     }




      public function forgetPassword(Request $request)
    {
       
           $data= $request->validate([
                'email' => 'required|string|email|exists:companies,email',
            ]);
    
            $Company = Company::where('email',$data['email'])->first();

            if(!$Company){
                return ('الحساب غير مسجل , حاول ادخال بريد اخر');
            }

            $token = Str::random(40);
            $url='/'.$token;
            
            $title="تغيير كلمة المرور ";    
    
            Notification::send(new ResetPasswordNotification,$url,$title);    

            PasswordReset::updateOrCreate(
                ['email'=>$data['email']]
                ,
                [
                    'email'=>$data['email'],
                    'token'=>$token,
                    'created_at'=>Carbon::now()->format('Y-m-d H-i-s'),
                ]
                );
            return response()->json(['message' =>'Email Sended Successfully','Company'=>$Company]);
      
    }


    public function resetPassword($token)
    {
    
            $passwordResetData = PasswordReset::where('token',$token)->first();

            if(!$token){
                return ('الحساب غير مسجل , حاول ادخال بريد اخر');
            }

             $company = Company::where('email',$passwordResetData->email)->first();
             return view('changePassword',with(
                [
                
                'person'=>$company,
             ]
            )
             );
      
    }


     public function ChangePassword(Request $request)
    {
             $data=$request->validate([
                'password'=>'required|string',
             ]);
             
            $company = Company::where('id',$request->id)->first();
            $company->update($data);
            
            return response()->json(['message' =>'Company Updated Successfully','Company'=>$Company]);
      
    }
    









}
