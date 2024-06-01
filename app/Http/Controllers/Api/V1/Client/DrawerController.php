<?php

namespace App\Http\Controllers\Api\V1\Client;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Client\DrawerResource;
use App\Enum\{DepositTypeEnum, MoneyTypeEnum, UserTypeEnum}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          ;
use App\Http\Resources\Api\V1\Client\{TraderResource, DepositOperationResource};
use App\Models\{DepositOperation, Trader, FinancialUser, purchasing, SectoralSelling, WholeSale};

class DrawerController extends Controller
{

    protected $DrawerResource = DrawerResource::class;

    public function showDataStatistics()
    {
        $dataClients = Trader::oftype([UserTypeEnum::CLIENT])
        ->ofUser(auth()->id())
        ->select(['id', 'credit_balance_sectoral', 'debit_balance_sectoral'])->get();
         // return auth()->user();

        return [
            "drawer_balance" => auth()->user()?->financial?->drawer_balance . ' ' . __('messages.pound'),
            "ton_numbers" => auth()->user()?->financial?->drawer_ton,
            "credit_balance" => $dataClients->sum("credit_balance_sectoral") . ' ' . __('messages.pound'),
            "debit_balance" => $dataClients->sum("debit_balance_sectoral") . ' ' . __('messages.pound'),
        ];
    }


}
