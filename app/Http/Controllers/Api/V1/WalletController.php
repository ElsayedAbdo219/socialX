<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\Transaction\TransactionReasonEnum;
use App\Enum\WalletTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Client\ChargeWalletRequest;
use App\Http\Resources\Api\V1\Client\WalletResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\{Request};

class WalletController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        return $this->respondWithCollection(WalletResource::collection(auth()->user()?->wallet));
    }

    public function balance(Request $request)
    {
        return $this->respondWithArray([
            'balance' => auth()->user()?->wallet()->sum('steps'),
            'has_pending_withdraw_request' => auth()->user()?->lastWithdrawRequest?->status == 'pending'
        ]);
    }

    public function chargeWallet(ChargeWalletRequest $request)
    {
        $response = myFatoorahTransaction(
            data: ['transaction_reason' => TransactionReasonEnum::USER_CHARGE_WALLET],
            amount: $request->balance
        );

        return $this->respondWithArray($response);
    }

    public function withDrawRequest()
    {
        $userBalance = auth()->user()?->walletBalance(WalletTypeEnum::MONEY);
        if ($userBalance <= 0) {
            return $this->respondWithError(__(
                'messages.can not create withdraw request because your amount is :amount',
                ['amount' => $userBalance]
            ));
        }

        if (auth()->user()?->lastWithdrawRequest?->status == 'new') {
            return $this->respondWithError(__('messages.can not create withdraw request because you has a pending request'));
        }

        auth()->user()?->withdrawRequests()->create([
           'amount' => $userBalance,
           'status' => 'new',
        ]);
        return $this->respondWithSuccess(__('messages.withdraw request sent successfully'));
    }
}
