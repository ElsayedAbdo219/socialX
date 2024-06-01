<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\Trader;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Api\Auth\AuthException;
use Illuminate\Foundation\Http\FormRequest;
use App\Notifications\DashboardNotification;
use App\Http\Requests\Api\Auth\RegisterClientRequest;

class AuthClientService extends AuthAbstract
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function deleteAccount(Request $request): JsonResponse
    {
        $user = $request->user();
        if(is_null($user)) {
            throw AuthException::userNotFound(['unauthorized' => [__('Unauthorized')]], 401);
        }

        DB::beginTransaction();
        $user->tokens()->delete();
        if($user->delete()) {
            DB::commit();
            return $this->respondWithSuccess(__('Deleted Successfully'));
        }
        DB::rollBack();

        return $this->setStatusCode(400)->respondWithError(__('Failed Operation'));
    }

    public function register(FormRequest $request, $abilities = null, $type = UserTypeEnum::CLIENT): User
    {
        if(!($request instanceof RegisterClientRequest)) {
            throw AuthException::wrongImplementation(['wrong_implementation' => [__("Failed Operation")]]);
        }

        $data = $request->validated();
        $data['type'] = $type;
        $data['is_active'] = false;

        DB::beginTransaction();

        $user = User::create($data);

        $user->financial()->create([]);

        Trader::create([
            'name' => UserTypeEnum::MAKHZANY,
            'phone' =>  $user->mobile,
            'user_id' => $user->id,
            'type' => UserTypeEnum::CLIENT,
        ]);

        DB::commit();

        $notifabel = User::whereType('admin')->first();
    
        $notificationData = [
          'title' => __('dashboard.new_request'),
          'body' => __('dashboard.new_request_from') . '  '.$user->name,
        ];
       // return $notificationData;
        # sending a notification to the user
        \Illuminate\Support\Facades\Notification::send($notifabel,
        new DashboardNotification($notificationData, ['database', 'firebase']));


        if(!$user->wasRecentlyCreated) {
            throw AuthException::userFailedRegistration(['genration_failed' => [__("Failed Operation")]]);
        }

        $user->access_token = $user->createToken('snctumToken', $abilities ?? [])->plainTextToken;
        $this->addTokenExpiration($user->access_token);

        return $this->handelMobileOTP($user);
    }
}
