<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\VerifyOTPRequest;
use App\Http\Requests\Api\Profile\UpdatePasswordRequest;
use App\Http\Requests\Api\V1\Client\UpdateProfileRequest;
use App\Http\Resources\Api\Auth\ClientResource;
use App\Http\Resources\Api\V1\Client\UserResource;
use App\Repositories\Contracts\ProfileContract;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    use ApiResponseTrait;

    protected mixed $modelResource = UserResource::class;

    public function __construct(protected ProfileContract $repository)
    {
    }


    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $flagUpdated = $this->repository->updateAccountPassword($request->validated());
        if (!$flagUpdated) {
            return $this->respondWithError(__('messages.responses.incorrect_old_password'));
        }
        return $this->respondWithSuccess(__('messages.responses.password_updated'));
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $this->repository->updateProfile($request->validated());
        return $this->respondWithModelData(
            new ClientResource($user)
        );
    }

    public function verifyUpdatedOTPForMobile(VerifyOTPRequest $request): JsonResponse
    {
        $flagUpdated = $this->repository->verifyOTP($request->validated());
        if (!$flagUpdated) {
            return $this->respondWithError(__('messages.responses.otp invalid'));
        }
        return $this->respondWithSuccess(__('messages.responses.mobile update successfully'));
    }

}
