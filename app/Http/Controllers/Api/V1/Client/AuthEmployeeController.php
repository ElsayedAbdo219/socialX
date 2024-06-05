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
use Illuminate\Support\Facades\Storage;

class AuthEmployeeController extends Controller
{
    public function register(Request $request)
    {
           $data= $request->validate([
                'name' => 'required|string|max:255',
                'job' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
                'personal_photo' => 'image|mimes:jpeg,png,jpg',
                'personal_info' => 'string',
                'website' => 'string|url',
                'experience' => 'string',
                'coverletter' => 'image|mimes:jpeg,png,jpg',
                'address' => 'required|string',
            ]);
            $data['type']=UserTypeEnum::EMPLOYEE;
            $employee = Member::create($data);

            if ($request->file('personal_photo')) {

                $personal_photo = uniqid() . '_' . $request->file('personal_photo')->getClientOriginalName();
      
                Storage::disk("local")->put($personal_photo, file_get_contents($request->file('personal_photo')));
      
      
                $employee->update(
                  [
      
                  'personal_photo'=> $personal_photo,
      
                  ]
            );
             
            }
    

            if ($request->file('coverletter')) {

                $coverletter = uniqid() . '_' . $request->file('coverletter')->getClientOriginalName();
      
                Storage::disk("local")->put($coverletter, file_get_contents($request->file('coverletter')));
      
      
                $employee->update(
                  [
      
                  'coverletter'=> $coverletter,
      
                  ]
            );
             
            }
    

           return response()->json(['message' =>'تم تسجيل الحساب بنجاح','employee'=>$employee]);
    
      
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
                'email' => ['البريد الالكتروني غير مسجل'],
            ]);
        }
        
        if ($request->password !=  $employee->password){
            throw ValidationException::withMessages([
                'password' => ['كلمة المرور غير صحيحة'],
            ]);
           }

        $token = $employee->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token , 'employee'=>$employee]);

    }


    public function logout()
    {
        
        $user = auth("api")->user()->currentAccessToken()->delete();
    
        return response()->json(['message' => 'تم تسجيل خروجك بنجاح' ]);
    }

    public function update(Request $request)
    {
       
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members,email,' . auth('api')->id(),
            'password' => 'nullable|string',
            'personal_photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'personal_info' => 'nullable|string',
            'website' => 'nullable|string|url',
            'experience' => 'nullable|string',
            'coverletter' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        
            auth('api')->user()->update($data);
    
            return response()->json(['message' =>'تم تحديث بياناتك بنجاح','employee'=>auth('api')->user()]);
      
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
