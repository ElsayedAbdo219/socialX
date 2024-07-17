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
use Illuminate\Support\Facades\Storage;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Notification;

use   App\Notifications\ClientNotification;

class AuthCompanyController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'birth_date' => 'required|string|max:255',
            'field' => 'required|string|max:255',
        ]);

        $data['type'] = UserTypeEnum::COMPANY;

        $data['password'] = Hash::make($data['password']);


        $company = Member::create($data);

         # sending a notification to the user   
        $notifabels =User::first();
        $notificationData = [
            'title' => "تسجيل شركة جديدة",
            'body' => "قام " . $data['full_name'] . " بتسجيل شركة جديدة",
        ];

        \Illuminate\Support\Facades\Notification::send(
            $notifabels,
            new ClientNotification($notificationData, ['database', 'firebase'])
        );

        $company->access_token = $company->createToken('sanctumToken', $abilities ?? [])->plainTextToken;
        /* $this->addTokenExpiration($company->access_token); */

        return response()->json(['message' => 'تم تسجيل حسابك بنجاح', 'company' => $company]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:members,email,type,' . UserTypeEnum::COMPANY,
            'password' => 'required',
        ]);


        $company = Member::whereEmail($request->email)->first();

        //  return [$request->password, $company->password];

        if (!$company) {
            throw ValidationException::withMessages([
                'email' => ['البريد الالكتروني غير صحيح'],
            ]);
        }

        if (!Hash::check($request->password, $company->password)) {
            throw ValidationException::withMessages([
                'password' => ['كلمة المرور غير صحيحة'],
            ]);
        }

        $token = $company->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token, 'company' => $company->load(['posts','followersTotal','rateCompany','rateCompanyTotal','follower'])]);
    }
    // public function changePassword(Request $request){

    // }



    public function logout(Request $request)
    {

        $user = auth("api")->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'تم تسجيل خروجك بنجاح']);
    }

    public function update(Request $request)
    {

        $data = $request->validate([
             'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:members',
            'password' => 'nullable|confirmed|min:6',
            'phone' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'birth_date' => 'nullable|string|max:255',
            'field' => 'nullable|string|max:255',
            'personal_photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'coverletter' => 'nullable|image|mimes:jpeg,png,jpg',
            'website' => 'nullable|url|string',
            'bio' => 'nullable|string',
        ]);

        auth('api')->user()->update($data);


        if ($request->file('personal_photo')) {

            $personal_photo = uniqid() . '_' . $request->file('personal_photo')->getClientOriginalName();

            //  Storage::disk("local")->put($personal_photo, file_get_contents($request->file('personal_photo')));

            Storage::put('public/members/' . $personal_photo, file_get_contents($request->file("personal_photo")));

            auth('api')->user()->update(
                [

                    'personal_photo' => $personal_photo,

                ]
            );
        }

        if ($request->file('coverletter')) {

            $coverletter = uniqid() . '_' . $request->file('coverletter')->getClientOriginalName();


            Storage::put('public/members/' . $coverletter, file_get_contents($request->file("coverletter")));

            //  Storage::disk("local")->put($coverletter, file_get_contents($request->file('coverletter')));


            auth('api')->user()->update(
                [

                    'coverletter' => $coverletter,

                ]
            );
        }


        return response()->json(['message' => 'تم تحديث بياناتك  بنجاح','company' => auth('api')->user()]);
    }


    public function deleteMyAccount()
    {
        Member::whereId(auth()->user()->id)->delete();
        return response()->json(['message' => 'تم حذف حسابك بنجاح']);
    }


    public function verifyOtp()
    {

        $codeRandom = rand(9999, 10000);

        // Mail::send(class name , $codeRandom in constructed);

        return response()->json(['message' => 'Email Sended To ' . auth()->user()->name . ' Successfully']);
    }








    public function ChangePassword(Request $request)
    {
        $data = $request->validate([
            'password' => 'required|string|confirmed|min:6',
        ]);

        $company = Member::where('id', auth('api')->user()->id)->first();
        $company->update($data);

        return response()->json(['message' => 'تم تغيير كلمة المرور بنجاح', 'Company' => $company]);
    }
}
