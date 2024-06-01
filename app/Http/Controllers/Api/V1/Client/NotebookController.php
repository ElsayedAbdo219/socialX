<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Client\DrawerResource;
use App\Enum\{ UserTypeEnum};
use App\Models\{DepositOperation, Trader};

class NotebookController extends Controller
{

    protected $DrawerResource = DrawerResource::class;

    public function showDataStatistics()
    {
        $dataTraders = Trader::select(['id','company_balance', 'credit_balance', 'debit_balance'])
        ->ofUser(auth()->id())
        ->get();

        return [
            "notebook_balance" => auth()->user()?->financial?->notebook_balance. ' ' .__('messages.pound'),
            "ton_numbers" => auth()->user()?->financial?->notebook_ton,
            "credit_balance" =>$dataTraders->sum("credit_balance") + $dataTraders->sum("company_balance") . ' ' . __('messages.pound'),
            "debit_balance" => $dataTraders->sum("debit_balance") . ' ' . __('messages.pound'),
        ];
    }

}
