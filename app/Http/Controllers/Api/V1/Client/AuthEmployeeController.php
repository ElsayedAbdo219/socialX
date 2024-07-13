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
use   App\Notifications\ClientNotification;

class AuthEmployeeController extends Controller
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
            'field' => 'nullable|string|max:255',
        ]);
        $data['type'] = UserTypeEnum::EMPLOYEE;
        $data['password'] = Hash::make($data['password']);


        $employee = Member::create($data);


        # sending a notification to the user   
        $notifabels = User::first();
        $notificationData = [
            'title' => "تسجيل مستقل جديدة",
            'body' => "قام " . $data['full_name'] . " بتسجيل مستقل جديدة",
        ];

        \Illuminate\Support\Facades\Notification::send(
            $notifabels,
            new ClientNotification($notificationData, ['database', 'firebase'])
        );


        $employee->access_token = $employee->createToken('sanctumToken', $abilities ?? [])->plainTextToken;


        return response()->json(['message' => 'تم تسجيل الحساب بنجاح', 'employee' => $employee]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:members,email,type,' . UserTypeEnum::EMPLOYEE,
            'password' => 'required',
        ]);

        $employee = Member::whereEmail($request->email)->first();


        if (!$employee) {
            throw ValidationException::withMessages([
                'email' => ['البريد الالكتروني غير مسجل'],
            ]);
        }

        if (!Hash::check($request->password, $employee->password)) {
            throw ValidationException::withMessages([
                'password' => ['كلمة المرور غير صحيحة'],
            ]);
        }

        $token = $employee->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token, 'employee' => $employee->load('experience','posts','rateEmployee','rateEmployeeTotal','rateCompany','education','position','skills')]);
    }


    public function logout()
    {

        $user = auth("api")->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'تم تسجيل خروجك بنجاح']);
    }

    public function update(Request $request)
    {

        $data = $request->validate([
            'personal_photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'personal_info' => 'nullable|string',
            'website' => 'nullable|string|url',
            'job' => 'nullable|string',
            'bio' => 'nullable|string',
            'coverletter' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);


        auth('api')->user()->update($data);

        if ($request->file('personal_photo')) {
            
            $personal_photo = uniqid() . '_' . $request->file('personal_photo')->getClientOriginalName();

            Storage::disk("local")->put($personal_photo, file_get_contents($request->file('personal_photo')));

            //Storage::put('public/members/' . $personal_photo, file_get_contents($request->file("personal_photo")));

            auth('api')->user()->update(
                [

                    'personal_photo' => $personal_photo,

                ]
            );
        }

        if ($request->file('coverletter')) {

            $coverletter = uniqid() . '_' . $request->file('coverletter')->getClientOriginalName();


            //Storage::put('public/members/' . $coverletter, file_get_contents($request->file("coverletter")));

          Storage::disk("local")->put($coverletter, file_get_contents($request->file('coverletter')));


            auth('api')->user()->update(
                [

                    'coverletter' => $coverletter,

                ]
            );
        }

        return response()->json(['message' => 'تم تحديث بياناتك بنجاح', 'employee' => auth('api')->user()]);
    }






    public function ChangePassword(Request $request) : mixed
    {
        $data = $request->validate([
            'password' => 'required|string|confirmed|min:6',
        ]);

        $Employee = Member::where('id', auth('api')->user()->id)->first();
        $Employee->update($data);

        return response()->json(['message' => 'تم تحديث كلمة المرور بنجاح', 'Employee' => $Employee]);
    }


    public function deleteMyAccount()
    {
        Member::whereId(auth()->user()->id)->delete();
        return response()->json(['message' => 'تم حذف حسابك بنجاح']);
    }
}
