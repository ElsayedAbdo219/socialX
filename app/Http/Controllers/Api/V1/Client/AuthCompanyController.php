<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Enum\UserTypeEnum;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    Member,
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

          $data['type']=UserTypeEnum::COMPANY;
    
            $company = Member::create($data);
    
           return response()->json(['message' =>'Company Register Successfully','company'=>$company]);
      
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:companies',
            'password' => 'required',
        ]);

       
        $company = Member::whereEmail($request->email)->first();

        if (!$company) {
            throw ValidationException::withMessages([
                'email' => ['The provided email does not exist.'],
            ]);
        }
        
        if (!Hash::check($request->password, $company->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided password is incorrect.'],
            ]);
           }

    $token = $company->createToken('api_token')->plainTextToken;

    return response()->json(['token' => $token,'company'=>$company]);

    }



    public function logout(Request $request)
    {
       
        $user = auth("api")->user()->logout();

        $user->tokens()->where('name', 'auth_token')->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function update(Request $request,$id)
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
    
            $company = Member::findOrFail($id);
    
            $company->update($data);
    
            return response()->json(['message' =>'Company Updated Successfully','company'=>$company]);
      
    }

    
     public function deleteMyAccount(){
        Member::whereId(auth()->user()->id)->destroy();
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
