<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Enum\{DepositTypeEnum, MoneyTypeEnum, UserTypeEnum, OperationTypeEnum};
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Client\{TraderResource, DepositOperationResource};
use App\Models\{DepositOperation, Trader};
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
        ], $request->all());

        $phones = Trader::OfUser(auth()->id())->pluck('phone')->toArray();

        if (in_array($request->phone, $phones)) {
            return $this->respondWithError('رقم التليفون موجود مسبقا');
        }


        $trader = Trader::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'user_id' => auth('api')->user()->id,
            'type' => UserTypeEnum::SUPPLIER,
        ]);

        return $this->respondWithArray(['data' => TraderResource::make($trader)]);
    }

    public function all()
    {
        $suppliers = Trader::ofType([UserTypeEnum::SUPPLIER])
            ->ofUser(auth()->id())->get();
        return $this->respondWithArray(['data' => TraderResource::collection($suppliers)]);
    }


    public function deposit(Request $request)
    {

        $request->validate([
            'type' => ['required', 'in:credit,debit'],
            'amount' => ['required', 'numeric'],
            'trader_id' => ['required'],
        ], $request->all());

        $supplier = Trader::findOrFail($request->trader_id);

        $data = $request->all();
        // $data['type'] = MoneyTypeEnum::REPAYMENT->value;
        $data['deposit_type'] = '';
        $data['deposit_operation_type'] = OperationTypeEnum::WHOLE;
        DB::beginTransaction();

        $user = auth()->user();


        if ($request->type == 'credit') {

            # حد بيسددلي فلوس الدفتر #

            if ($supplier->credit_balance == (float)$request->amount) {
                $supplier->update([
                    "credit_balance" => 0
                ]);
            } elseif ($supplier->credit_balance > (float)$request->amount) {
                $supplier->update([
                    'credit_balance' =>  $supplier->credit_balance - ((float)$request->amount - $supplier->debit_balance),
                ]);
            } elseif ($supplier->credit_balance < (float)$request->amount) {
                $supplier->update([
                    'debit_balance' =>  $supplier->debit_balance +  ((float)$request->amount - $supplier->credit_balance),
                    "credit_balance" => 0

                ]);
            }


            # لو  ليه فهيقلل المبلغ اللي له و هيزود فلوس الدفتر #

            $user->financial()->update([
                'notebook_balance' => $user->financial->notebook_balance + (float)$request->amount
            ]);


            $data['type'] = MoneyTypeEnum::REPAYMENT_CREDIT->value;
        } elseif ($request->type == 'debit') {

            if ($user->financial->notebook_balance > (float)$request->amount) {

                if ($supplier->debit_balance > (float)$request->amount) {

                    $supplier->update([
                        'debit_balance' => $supplier->debit_balance - (float)$request->amount
                    ]);
                } elseif ($supplier->debit_balance < (float)$request->amount) {
                    $supplier->update([
                        'credit_balance' =>  $supplier->credit_balance + ((float)$request->amount - $supplier->debit_balance),
                        "debit_balance" => 0
                    ]);
                } elseif ($supplier->debit_balance == (float)$request->amount) {
                    $supplier->update([
                        "debit_balance" => 0
                    ]);
                }

                # لو عليه فهيقلل الميلغ اللي عليه و ينقص فلوس الدفتر #
                $user->financial()->update([
                    'notebook_balance' => $user->financial->notebook_balance - (float)$request->amount
                ]);

                $data['type'] = MoneyTypeEnum::REPAYMENT_DEBIT->value;
            } else {
                return $this->respondWithError("الكمية المراد ايداعها اكبر من ميزانية الدفتر");
            }
        }



        DepositOperation::create($data);


        DB::commit();

        return $this->respondWithSuccess('تم التسديد بنجاح');
    }


    public function getBalance(Trader $trader)
    {
        return $this->respondWithArray(['credit_balance' => $trader->credit_balance, 'debit_balance' => $trader->debit_balance]);
    }

    public function getDepositAndSettlementOperations(Trader $trader, MoneyTypeEnum $type)
    {
        $depositOperations = $trader->depositOperation()->with('depositAnother')
            ->ofType($type)->get();
        return $this->respondWithArray([
            'data' => DepositOperationResource::collection($depositOperations)
        ]);
    }
}
