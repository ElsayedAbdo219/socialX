<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Enum\{DepositTypeEnum, MoneyTypeEnum, UserTypeEnum};
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Client\{TraderResource, DepositOperationResource};
use App\Models\{DepositOperation, SectoralSelling, Trader, WholeSale};
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enum\OperationTypeEnum;

class ClientController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
        ],$request->all());
    

    $phones = Trader::OfUser(auth()->id())->pluck('phone')->toArray();

    if (in_array($request->phone, $phones)) {
        return $this->respondWithError('رقم التليفون موجود مسبقا');
    }
      
        
        $trader = Trader::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'user_id' => auth('api')->user()->id,
            'type' => UserTypeEnum::CLIENT,
        ]);
        return $this->respondWithArray(['data' => TraderResource::make($trader)]);
    }

    public function all()
    {
        $clients = Trader::ofType([UserTypeEnum::CLIENT])
            ->ofUser(auth()->id())->get();
        return $this->respondWithArray(['data' => TraderResource::collection($clients)]);
    }

    public function deposit(Request $request,$type_sail)
    {

        $request->validate([
            'type' => ['required', 'in:credit,debit'],
            'amount' => ['required', 'numeric'],
            'trader_id' => ['required'],
        ], $request->all());

        $client = Trader::findOrFail($request->trader_id);

        $data = $request->all();
      //  $data['type'] = MoneyTypeEnum::REPAYMENT->value;
        $data['deposit_type'] = '';

        DB::beginTransaction();

        $user = auth()->user();

        if ($request->type == 'credit') {
            # حد بيسددلي فلوس الدرج #
            if ($type_sail == OperationTypeEnum::WHOLE) {
                 # حد بيسددلي فلوس الدفتر #
            
            if($client->credit_balance == (double)$request->amount){
                $client->update([
                    "credit_balance"=> 0
                ]);
              }

              elseif($client->credit_balance > (double)$request->amount){
                $client->update([
                    'credit_balance' =>  $client->credit_balance - ((double)$request->amount - $client->debit_balance)  ,
                ]);

              }

              elseif($client->credit_balance < (double)$request->amount){
                $client->update([
                    'debit_balance' =>  $client->debit_balance +  ((double)$request->amount - $client->credit_balance)  ,
                    "credit_balance"=> 0

                ]);
                
              }

            if($client->name === UserTypeEnum::MAKHZANY){
                $user->financial()->update([
                    'notebook_balance' => $user->financial->notebook_balance + (float)$request->amount,
                    'drawer_balance' => $user->financial->drawer_balance -  (float)$request->amount
                ]);
            }else{
                $user->financial()->update([
                    'notebook_balance' => $user->financial->notebook_balance + (float)$request->amount,
                ]);

            }

                $data['deposit_operation_type'] = OperationTypeEnum::WHOLE;


            } 
            
            elseif ($type_sail == OperationTypeEnum::SECTORAL) {

                if($client->credit_balance_sectoral == (double)$request->amount){
                    $client->update([
                        "credit_balance_sectoral"=> 0
                    ]);
                  }
    
                  elseif($client->credit_balance_sectoral > (double)$request->amount){
                    $client->update([
                        'credit_balance_sectoral' =>  $client->credit_balance_sectoral - ((double)$request->amount - $client->debit_balance_sectoral)  ,
                    ]);
    
                  }
    
                  elseif($client->credit_balance_sectoral < (double)$request->amount){
                    $client->update([
                        'debit_balance_sectoral' =>  $client->debit_balance_sectoral +  ((double)$request->amount - $client->credit_balance_sectoral)  ,
                        "credit_balance_sectoral"=> 0
    
                    ]);
                    
                  }


                $user->financial()->update([
                    'drawer_balance' => $user->financial->drawer_balance + (float)$request->amount
                ]);

                $data['deposit_operation_type'] = OperationTypeEnum::SECTORAL;

            }

            $data['type'] = MoneyTypeEnum::REPAYMENT_CREDIT->value;

            DepositOperation::create($data);


            DB::commit();
    
            return $this->respondWithSuccess("تم استلام مبلغ  بنجاح");

        } 
        
        elseif ($request->type == 'debit') {

            if ($type_sail == OperationTypeEnum::WHOLE) {


                if($user->financial->notebook_balance >= $request->amount ){
                if($client->debit_balance > (double)$request->amount){
            
                    $client->update([
                        'debit_balance' => $client->debit_balance - (double)$request->amount
                    ]);
                    }
                  elseif($client->debit_balance < (double)$request->amount){
                    $client->update([
                        'credit_balance' =>  $client->credit_balance + ((double)$request->amount - $client->debit_balance)  ,
                        "debit_balance"=> 0
                    ]);
        
                  }elseif($client->debit_balance == (double)$request->amount){
                    $client->update([
                        "debit_balance"=> 0
                    ]);
                  }

                  if($client->name === UserTypeEnum::MAKHZANY){
                    $user->financial()->update([
                        'notebook_balance' => $user->financial->notebook_balance -  (float)$request->amount,
                        'drawer_balance' => $user->financial->drawer_balance +  (float)$request->amount
                    ]);
                }else{
                    $user->financial()->update([
                        'notebook_balance' => $user->financial->notebook_balance - (float)$request->amount,
                    ]);
    
                }
            }
            else{
                return $this->respondWithError("الكمية المراد ايداعها اكبر من ميزانية الدفتر");
            }

            $data['deposit_operation_type'] = OperationTypeEnum::WHOLE;


        }

            
            elseif ($type_sail == OperationTypeEnum::SECTORAL) {

                if($user->financial->drawer_balance > $request->amount ){

                if($client->debit_balance_sectoral > (float)$request->amount){
                $client->update([
                    'debit_balance_sectoral' => $client->debit_balance_sectoral - (float)$request->amount
                ]);
            }
                elseif($client->debit_balance_sectoral < (float)$request->amount){
                    $client->update([
                        'credit_balance_sectoral' => $client->credit_balance_sectoral +  ($request->amount - $client->debit_balance_sectoral)  ,
                        "debit_balance_sectoral"=> 0
                    ]);
        
                  }else{
                    $client->update([
                        "debit_balance_sectoral"=> 0
                    ]);

                    }
    

                $user->financial()->update([
                    'drawer_balance' => $user->financial->drawer_balance - (float)$request->amount
                ]);

          
            }
            else{
                return $this->respondWithError("الكمية المراد ايداعها اكبر من ميزانية الدرج الحالية");
            }

            $data['deposit_operation_type'] = OperationTypeEnum::SECTORAL;

        }

        $data['type'] = MoneyTypeEnum::REPAYMENT_DEBIT->value;

        DepositOperation::create($data);


        DB::commit();

        return $this->respondWithSuccess('تم التسديد بنجاح');

    }

       
    }

    public function getBalance(Request $request, Trader $trader)
    {
        if ($request->type == OperationTypeEnum::WHOLE) {
            return $this->respondWithArray(['credit_balance' => $trader->credit_balance, 'debit_balance' => $trader->debit_balance]);
        } elseif ($request->type == OperationTypeEnum::SECTORAL) {

            return $this->respondWithArray(['credit_balance' => $trader->credit_balance_sectoral, 'debit_balance' => $trader?->debit_balance_sectoral]);
        }
    }



    public function settlement(Request $request)
    {
        $request->validate([
            'trader_id' => ['required'],
            'amount' => ['required', 'numeric']
        ], $request->all());

        $data = $request->all();
        $data['type'] = MoneyTypeEnum::SETTLEMENT->value;
        $data['deposit_type'] = '';

        $company = Trader::findOrFail($request->trader_id);

        DB::beginTransaction();
        DepositOperation::create($data);
        $company->company_balance += $request->amount;
        $company->push();
        DB::commit();

        return $this->respondWithSuccess('تمت عملية التسوية بنجاح');
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
