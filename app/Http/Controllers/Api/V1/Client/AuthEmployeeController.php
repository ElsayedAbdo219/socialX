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
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;

class AuthEmployeeController extends Controller
{
    public function register(Request $request)
    {
           $data= $request->validate([
                'name' => 'required|string|max:255',
                'job' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
                'personal_photo' => 'string|image,mimes:jpeg,png,jpg',
                'personal_info' => 'string',
                'website' => 'string|url',
                'experience' => 'string',
                'coverletter' => 'image,mimes:jpeg,png,jpg',
                'address' => 'required|string|',
            ]);
            $data['type']=UserTypeEnum::EMPLOYEE;
            $employee = Member::create($data);
           return response()->json(['message' =>'Employee Regiser Successfully','employee'=>$employee]);
    
      
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:members,email',
            'password' => 'required',
        ]);

        $employee = Member::whereEmail($request->email)->first();
      //  return [$employee->password , $request->password];

        if (!$employee ) {
            throw ValidationException::withMessages([
                'email' => ['The provided email does not exist.'],
            ]);
        }
        
        if ($request->password !=  $employee->password){
            throw ValidationException::withMessages([
                'password' => ['The provided password is incorrect.'],
            ]);
           }

        $token = $employee->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token , 'employee'=>$employee]);

    }


    public function logout()
    {
        return "dsfsdfg";

        $user = auth("api")->user()->logout();  

        $user->tokens()->where('name', 'auth_token')->delete();
    
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function update(Request $request)
    {
       
           $data= $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:employees',
                'password' => 'required',
                'personal_photo' => 'string|image,mimes:jpeg,png,jpg',
                'personal_info' => 'string',
                'website' => 'string|url',
                'experience' => 'string',
                'coverletter' => 'image,mimes:jpeg,png,jpg',
            ]);
    
            $employee = Member::findOrFail($id);
    
            $employee->update($data);
    
            return response()->json(['message' =>'Employee Updated Successfully','employee'=>$employee]);
      
    }



    public function forgetPassword(Request $request)
    {
       
           $data= $request->validate([
                'email' => 'required|string|email|exists:employees,email',
            ]);
    
            $employee = Employee::where('email',$data['email'])->first();

            if(!$employee){
                return ('الحساب غير مسجل , حاول ادخال بريد اخر');
            }

            $token = Str::random(40);
            $url='/'.'employees/reset-password/'.$token;
            
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
            return response()->json(['message' =>'Email Sended Successfully','employee'=>$employee]);
      
    }


    public function resetPassword($token)
    {
    
            $passwordResetData = PasswordReset::where('token',$token)->first();

            if(!$token){
                return ('الحساب غير مسجل , حاول ادخال بريد اخر');
            }

             $Employee = Employee::where('email',$passwordResetData->email)->first();
             return view('changePassword',with(
                [
                
                'person'=>$Employee,
             ]
            )
             );
      
    }


     public function ChangePassword(Request $request)
    {
             $data=$request->validate([
                'password'=>'required|string',
             ]);
             
            $Employee = Employee::where('id',$request->id)->first();
            $Employee->update($data);
            
            return response()->json(['message' =>'Employee Updated Successfully','Employee'=>$Employee]);
      
    }
    

    public function deleteMyAccount(){
        Employee::whereId(auth()->user()->id)->destroy();
        return response()->json(['message' =>'Employee Deleted Successfully']);

     }


}
