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
    public function register(Request $request, $type)
    {
     
        if($type == UserTypeEnum::Employee){
           $data= $request->validate([
                'name' => 'required|string|max:255',
                'job' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string',
                'personal_photo' => 'string|image,mimes:jpeg,png,jpg',
                'personal_info' => 'string',
                'website' => 'string|url',
                'experience' => 'string',
                'coverletter' => 'image,mimes:jpeg,png,jpg',
            ]);
            $data['password'] = Hash::make($request->password);

            $employee = Employee::create($data);
           return response()->json(['message' =>'Employee Updated Successfully','employee'=>$employee]);
        }

        elseif($type == UserTypeEnum::COMPANY){
          
                $data=$request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string',
                'logo' => 'image,mimes:jpeg,png,jpg',
                'slogo' => 'string',
                'website' => 'url|string',
                'address' => 'string',
                'bio' => 'string',
            ]);

            $data['password'] = Hash::make($request->password);
    
            $company = Company::create($data);
    
           return response()->json(['message' =>'Company Updated Successfully','company'=>$company]);
        }
      
    }

    public function login(Request $request,$type)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($type == UserTypeEnum::Employee){
            $employee = Employee::where('email', $request->email)->first();

            if (!$employee || !Hash::check($request->password, $employee->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
    
            $token = $employee->createToken('auth_token')->plainTextToken;
    
            return response()->json(['token' => $token], 200);
    }


    elseif($type == UserTypeEnum::COMPANY){
    $company = Company::where('email', $request->email)->first();

    if (!$company || !Hash::check($request->password, $company->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $company->createToken('auth_token')->plainTextToken;

    return response()->json(['token' => $token], 200);



    }
}


    /**
     * Logout the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout($type)
    {
        $user = Auth::user();
    
        if ($type == UserTypeEnum::Employee) {
            $user->tokens()->where('name', 'auth_token')->delete();
        } elseif ($type == UserTypeEnum::COMPANY) {
            $user->tokens()->where('name', 'auth_token')->delete();
        }
    
        return response()->json(['message' => 'Logged out successfully']);
    }




    public function update(Request $request,string $type)
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
    
    
            auth()->user()->update($data);
    
            return response()->json(['message' =>'Employee Updated Successfully']);
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
    
            $company = Company::findOrFail($id);
    
            $company->update($data);
    
            return response()->json(['message' =>'Company Updated Successfully','company'=>$company]);
        }

      
    }

    


}
