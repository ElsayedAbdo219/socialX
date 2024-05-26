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
    public function register(Request $request,$type)
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
    
            $token = $employee->createToken('api_token')->plainTextToken;
    
            return response()->json(['token' => $token]);
        }

        elseif($type == UserTypeEnum::COMPANY){
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
                'logo' => 'image,mimes:jpeg,png,jpg',
                'slogo' => 'string',
                'website' => 'url|string',
                'address' => 'string',
                'bio' => 'string',
            ]);
    
            $company = Company::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $token = $company->createToken('api_token')->plainTextToken;
    
            return response()->json(['token' => $token]);
        }

      
    }



    public function login(Request $request,$type)
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


    


}
