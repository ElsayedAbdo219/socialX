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
class AuthController extends Controller
{
    public function register(Request $request, string $type)
    {
        if($type == UserTypeEnum::Employee){
           $data= $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
                'personal_photo' => 'string|image,mimes:jpeg,png,jpg',
                'personal_info' => 'string',
                'website' => 'string|url',
                'experience' => 'string',
                'coverletter' => 'image,mimes:jpeg,png,jpg',
            ]);
    
            $employee = Employee::create([$data]);
    
           return response()->json(['message' =>'Employee Updated Successfully','employee'=>$employee]);
        }

        elseif($type == UserTypeEnum::COMPANY){
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
      
    }

    public function login(Request $request,string $type)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if($type == UserTypeEnum::Employee){

        if (!Auth::guard('employee')->attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $employee = Employee::where('email', $request->email)->first();

        $token = $employee->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }



    elseif(!Auth::guard('company')->attempt($request->only('email', 'password'))){

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $company = Company::where('email', $request->email)->first();

    $token = $company->createToken('api_token')->plainTextToken;

    return response()->json(['token' => $token]);



    }


    /**
     * Logout the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request,$type)
    {
       if($type == UserTypeEnum::Employee){
        Auth::guard('employee')->user()->currentAccessToken()->delete();
       }

       elseif($type == UserTypeEnum::COMPANY){
        Auth::guard('company')->user()->currentAccessToken()->delete();

       }

        return response()->json(['message' => 'Logged out successfully']);
    }




    public function update(Request $request,string $type,int $id)
    {
        if($type == UserTypeEnum::Employee){
           $data= $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
                'personal_photo' => 'string|image,mimes:jpeg,png,jpg',
                'personal_info' => 'string',
                'website' => 'string|url',
                'experience' => 'string',
                'coverletter' => 'image,mimes:jpeg,png,jpg',
            ]);
    
            $employee = Employee::findOrFail($id);
    
            $employee->update($data);
    
            return response()->json(['message' =>'Employee Updated Successfully','employee'=>$employee]);
        }

        elseif($type == UserTypeEnum::COMPANY){
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
    
            $company = Employee::findOrFail($id);
    
            $company->update($data);
    
            return response()->json(['message' =>'Company Updated Successfully','company'=>$company]);
        }

      
    }

    


}
