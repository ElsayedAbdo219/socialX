<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Incentive;
use App\Enum\UserTypeEnum;
use App\Models\purchasing;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;

class IncentiveController extends Controller
{

  use ApiResponseTrait;

  public function add(Request $request)
  {


    $request->validate([
      'settlement_total' => ['required'],
      'from' => ['required'],
      'to' => ['required'],
    ], $request->all());


    $pushasingData = purchasing::OfUser(auth('api')->user()->id)->whereType(UserTypeEnum::COMPANY)->whereDate('created_at', '>=', $request->from)->whereDate('created_at', '<=', $request->to)->get();

    Incentive::create([
      'ton_quantity' => $pushasingData->sum('ton_quantity'),
      'ton_quantity_cutting' => $pushasingData->sum('ton_quantity_cutting'),
      'ton_quantity_price' => $pushasingData->sum('ton_quantity_price'),
      'nolon' => $pushasingData->sum('ton_colon_price') ?? 0,
      'settlement_total' => $request->settlement_total,
      'total' => $request->settlement_total - (($pushasingData->sum('ton_quantity_cutting') - $pushasingData->sum('ton_quantity_price')) * $pushasingData->sum('ton_quantity')) - $pushasingData?->sum('ton_colon_price'),
      'from' => $request->from,
      'to' => $request->to,
    ]);

    return $this->respondWithSuccess('تم اضافة التسوية بنجاح');
  }
}
