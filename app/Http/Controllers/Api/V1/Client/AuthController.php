<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Enum\Transaction\TransactionReasonEnum;
use App\Enum\UserTypeEnum;
use App\Enum\WalletTransactionReasonEnum;
use App\Enum\WalletTransactionTypeEnum;
use App\Enum\WalletTypeEnum;
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
use App\Http\Resources\Api\Auth\ClientResource;
use App\Models\User;
use App\Services\Auth\AuthClientService;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @group App Client
 * Manage Client App Apis
 *
 * @subGroup Auth
 * @subgroupDescription Auth Cycle Apis
 */
class AuthController extends Controller
{
    use ApiResponseTrait;

    private $authClientService;

    private string $modelResource = ClientResource::class;
    private array $relations = [];

    public function __construct(AuthClientService $authClientService)
    {
        $this->authClientService = $authClientService;
    }

    /**
     * Client Login.
     *
     * an API which Offers a mean to login a client
     * @unauthenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function login(LoginClientRequest $request): JsonResponse
    {
        $user = $this->authClientService->login($request);
        return $this->respondWithModelData(
            new ClientResource($user)
        );
    }

    /**
     * Client Register.
     *
     * an API which Offers a mean to register a new client
     * @unauthenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function register(RegisterClientRequest $request): JsonResponse
    {
        $registeredUser = $this->authClientService->register(
            request: $request
        );

        return $this->respondWithModelData(
            new ClientResource(
                $registeredUser
            )
        );
    }


    /**
     * Send OTP To Mobile Number.
     *
     * an API which Offers a mean to Send OTP To Mobile Number.
     * @unauthenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function sendOTP(SendOTPRequest $request): JsonResponse
    {
        return $this->respondWithArray(
            app()->isLocal() ? [
                "verification_code" =>
                    $this->authClientService->sendOTP($request)->OTP
            ] : []
        );
    }

    /**
     * Re-Send OTP.
     *
     * an API which Offers a mean to Re-Send OTP.
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function resendOTP(Request $request): JsonResponse
    {
        return $this->respondWithArray(
            app()->isLocal() ? [
                "verification_code" =>
                    $this->authClientService->resendOTP($request)->OTP
            ] : []
        );
    }

    /**
     * OTP Verification.
     *
     * an API which Offers a mean to verify user otp
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function verifyOTP(VerifyOTPRequest $request): JsonResponse
    {
        return $this->authClientService->verifyOTP($request);
    }

    /**
     * Client New Password.
     *
     * an API which Offers a mean to set new password for logged out clients after verification step.
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function resetpassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->authClientService->resetPassword($request);
    }

    /**
     * Client Change Password.
     *
     * an API which Offers a mean to Change password for logged in client.
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        return $this->authClientService->changePassword($request);
    }

    /**
     * Client Forget Password.
     *
     * an API which Offers a mean to reset client password for logged out clients.
     * @unauthenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {
        return $this->respondWithModelData(
            new ClientResource(
                $this->authClientService->forgetPassword($request)
            )
        );
    }

    /**
     * can Client Change Mobile.
     *
     * an API which Offers a mean to check if client can change mobile number if can send OTP.
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function canChangeMobile(ChangeMobileRequest $request): JsonResponse
    {
        return $this->respondWithArray(
            app()->isLocal() ? [
                "verification_code" =>
                    $this->authClientService->canChangeMobile($request)->OTP
            ] : []
        );
    }

    /**
     * Client Change Mobile.
     *
     * an API which Offers a mean to change client mobile number.
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function changeMobile(ChangeMobileRequest $request): JsonResponse
    {
        return $this->respondWithModelData(
            new ClientResource(
                $this->authClientService->changeMobile($request)
            )
        );
    }

    /**
     * validate email and mobile.
     *
     * an API which Offers a mean to Validate Email and Mobile.
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function validateMobileorEmail(ValidateMobileorEmailRequest $request): JsonResponse
    {
        return $this->authClientService->validateMobileorEmail($request);
    }

    /**
     * Client Profile.
     *
     * an API which Offers a mean to login a client
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function profile(Request $request): JsonResponse
    {
        return $this->respondWithModelData(
            new ClientResource(
                $this->authClientService->profile($request)
            )
        );
    }

    /**
     * Client logout.
     *
     * an API which Offers a mean to logout a client
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function logout(Request $request)
    {
        $this->authClientService->logout($request);
        return $this->respondWithSuccess(
            __('Logged out Successfully')
        );
    }

    /**
     * Client Delete Account.
     *
     * an API which Offers a mean to delete a client account
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function deleteAccount(Request $request): JsonResponse
    {
        return $this->authClientService->deleteAccount($request);
    }
}
