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
    // حذف جميع التوكنات القديمة لمنع تكرار الجلسات
    $member->tokens()->delete();

    // إنشاء Access Token بصلاحيات كاملة لمدة 60 دقيقة
    $accessToken = $member->createToken('access-token', ['*'], now()->addMinutes(60))->plainTextToken;

    // إنشاء Refresh Token بصلاحيات التحديث لمدة 7 أيام
    $refreshToken = $member->createToken('refresh-token', ['refresh'], now()->addDays(7))->plainTextToken;

   return $this->respondWithSuccess('User Logged In Successfully', [
        'member' => $member,
        'access_token' => $accessToken,
        'refresh_token' => $refreshToken,
        'token_type' => 'Bearer',
        'expires_in' => 60 * 60 // 1 ساعة
    ]);
    }

public function login(LoginClientRequest $request)
{
    $loginMemberData = $request->validated();
    $member = Member::where('email', $loginMemberData['email'])->first();

    if (!$member || !Hash::check($loginMemberData['password'], $member->password)) {
        return $this->errorUnauthorized('Invalid Credentials');
    }

    // حذف جميع التوكنات القديمة لمنع تكرار الجلسات
    $member->tokens()->delete();

    // إنشاء Access Token بصلاحيات كاملة لمدة 60 دقيقة
    $accessToken = $member->createToken('access-token', ['*'], now()->addMinutes(60))->plainTextToken;

    // إنشاء Refresh Token بصلاحيات التحديث لمدة 7 أيام
    $refreshToken = $member->createToken('refresh-token', ['refresh'], now()->addDays(7))->plainTextToken;

    return $this->respondWithSuccess('User Logged In Successfully', [
        'member' => $member,
        'access_token' => $accessToken,
        'refresh_token' => $refreshToken,
        'token_type' => 'Bearer',
        'expires_in' => 60 * 60 // 1 ساعة
    ]);
}



#Refresh Token 

    public function refreshToken(Request $request)
    {
        $user = auth()->user();

        // التحقق من أن التوكن المستخدم هو "Refresh Token"
        if (!$request->user()->currentAccessToken()->can('refresh')) {
            return response()->json(['message' => 'Invalid refresh token'], 403);
        }

        // حذف التوكنات القديمة
        $user->tokens()->delete();

        // إصدار Access Token جديد
        $newAccessToken = $user->createToken('access-token', ['*'], now()->addMinutes(60))->plainTextToken;

        // إصدار Refresh Token جديد
        $newRefreshToken = $user->createToken('refresh-token', ['refresh'], now()->addDays(7))->plainTextToken;

        return response()->json([
            'access_token' => $newAccessToken,
            'refresh_token' => $newRefreshToken,
            'token_type' => 'Bearer',
            'expires_in' => 60 * 60,
        ]);
    }

# Verification
public function verifyOtp(Request $request){
    $dataRequest = $request->validate([
        'email' => 'required|email|exists:members,email',
        'otp' => 'required|digits:6'
    ]);

    $otpRecord = OtpAuthenticate::where('email', $dataRequest['email'])->latest()->first();
    
    if (!$otpRecord) {
        return $this->errorUnauthorized('No OTP found.');
    }

    if (now()->greaterThan($otpRecord->expiryDate)) {
        return $this->errorUnauthorized('The OTP has expired.');
    }

    if ($dataRequest['otp'] != $otpRecord->otp) {
        return $this->errorUnauthorized('Invalid OTP.');
    }

    $member = Member::where('email', $otpRecord->email)->first();
    $member->email_verified_at = now();
    $member->save();
    $otpRecord->delete();
    $token= $member->createToken('sanctumToken')->plainTextToken;
    return $this->respondWithSuccess('User verified successfully.' ,['token'=>$token]);
}


# Resend Otp
public function resendOtp(Request $request){
    $dataRequest = $request->validate(['email'=>'required','exists:members,email']);
    $otpRecord = OtpAuthenticate::create([
        'email' => $dataRequest['email'],
        'otp' => rand(0, 999999),
        'expiryDate' => now()->addMinutes(12),
    ]);
     // إرسال OTP عبر البريد الإلكتروني
    // Mail::to($dataRequest['email'])->send(new OtpMail($otpRecord['otp']));
      return $this->respondWithSuccess('The Otp Resend Successfully , is '.$otpRecord['otp']);
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
    // return OtpAuthenticate::get();
    $dataRequest = $request->validate([
        'password' => 'required|string|min:8|confirmed'
    ]);
    $Member = $request->user();
    $Member->password = Hash::make($dataRequest['password']);
    $Member->save();
    OtpAuthenticate::where('email', $Member->email)->delete();
    $Member->tokens()->delete();
    return $this->respondWithSuccess('Password Has Changed Successfully');
}

public function me()
{
return auth()->user();

}


public function refresh()
{
return auth()->user();

}




}