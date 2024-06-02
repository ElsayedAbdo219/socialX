<?php

namespace App\Repositories\Concretes;

use App\Exceptions\Api\Auth\AuthException;
use App\Models\User;
use App\Repositories\Contracts\ProfileContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileConcrete extends BaseConcrete implements ProfileContract
{
    /**
     * RoleRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function updateAccountPassword($request): bool
    {
        $user = auth('api')->user();
        if (!Hash::check($request['old_password'], $user->password)) {
            return false;
        }
        $user->password = $request['password'];
        $user->save();

        return true;
    }

    public function updateProfile($request): mixed
    {
        DB::transaction(function () use ($request) {
            auth('api')->user()->update([
                'name' => $request['name'],
                'email' => $request['email'] ?? auth('api')->user()?->email,
            ]);
            if (isset($request['avatar'])) {
                uploadImage('avatar', $request['avatar'], auth('api')->user());
            }
        });
        return auth('api')->user()->fresh();
    }

    public function verifyOTP($request): bool
    {
        $user = auth('api')->user()->loadMissing('latestOTPToken');
        if (is_null($user->latestOTPToken)) {
            throw AuthException::otpNotGenerated(['genration_failed' => [__("Failed Operation")]]);
        }

        if ($user?->latestOTPToken?->isValid() && $request['code'] == $user->latestOTPToken->code) {
            DB::beginTransaction();
            $user->latestOTPToken->update(['active' => false,]);
            $user->update(['mobile' => $user?->latestOTPToken?->updated_mobile]);
            DB::commit();
            return true;
        }
        return false;

    }
}
