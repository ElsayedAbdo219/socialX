<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Enum\Transaction\TransactionReasonEnum;
use App\Enum\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ChangeMobileRequest;
use App\Http\Requests\Api\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\Auth\ForgetPasswordRequest;
use App\Http\Requests\Api\Auth\LoginClientRequest;
use App\Http\Requests\Api\Auth\RegisterClientRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\SendOTPRequest;
use App\Http\Requests\Api\Auth\ValidateMobileorEmailRequest;
use App\Http\Requests\Api\Auth\VerifyOTPRequest;
use App\Http\Resources\Api\Auth\LoginRequest;
use App\Models\{
    Member , OtpAuthenticate };
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    use ApiResponseTrait;

# Register
public function register(RegisterClientRequest $request){
    $dataValidated = $request->validated();
    $dataValidated['password'] = Hash::make($request->password);
    $member = Member::create($dataValidated);
    $member['token'] = $member->createToken('sanctumToken')->plainTextToken;
    return $this->respondWithSuccess('User Register Successfully', $member );
}

# Login & Authentication
public function login(LoginClientRequest $request){
       $loginMemberData =  $request->validated();
       $member = Member::where('email',$loginMemberData['email'])->first();
       if(!$member || !Hash::check($loginMemberData['password'],$member->password)){
        return $this->errorUnauthorized('Invalid Credentials');
       }

     $member['token'] = $member->createToken('sanctumToken')->plainTextToken;
     return $this->respondWithSuccess('User Logged In Successfully', $member );

}

    # Forget Password
public function forgetPassword(Request $request)
{
   
    $dataRequest = $request->validate([
        'email' => 'required|email|exists:members,email'
    ]);
    // حذف أي رموز OTP قديمة لنفس البريد الإلكتروني
    OtpAuthenticate::where('email', $dataRequest['email'])->delete();

    $otp = rand(0, 999999);

    OtpAuthenticate::create([
        'email'       => $dataRequest['email'],
        'otp'         => $otp,
        'expiryDate'  => now()->addMinutes(12),
    ]);

    // إرسال OTP عبر البريد الإلكتروني
    // Mail::to($dataRequest['email'])->send(new OtpMail($otp));
    return $this->respondWithSuccess(' OTP has been sent  is '.$otp);
}



# Reset Password
public function resetPassword(Request $request)
{
    $dataRequest = $request->validate([
        'email'    => 'required|email|exists:members,email',
        'otp'      => 'required|digits:6',
        'password' => 'required|string|min:8|confirmed'
    ]);

    $otpRecord = OtpAuthenticate::where('email', $dataRequest['email'])->latest()->first();

    if (!$otpRecord || Carbon::parse($otpRecord->expiryDate)->isPast()) {
        return $this->errorUnauthorized('The OTP is invalid or expired.');
    }

    if ($dataRequest['otp'] != $otpRecord->otp) {
        return $this->errorUnauthorized('Invalid OTP.');
    }

    // تحديث كلمة المرور
    $Member = Member::where('email', $dataRequest['email'])->first();
    $Member->password = Hash::make($dataRequest['password']);
    $Member->save();

    // حذف جميع رموز OTP القديمة
    OtpAuthenticate::where('email', $dataRequest['email'])->delete();

    // حذف جميع التوكنات القديمة وإنشاء توكن جديد
    $Member->tokens()->delete();
    $accessToken = $Member->createToken('sanctumToken')->plainTextToken;

    return $this->respondWithArray(["access_token" => $accessToken]);
}



}
