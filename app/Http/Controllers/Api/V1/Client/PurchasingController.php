<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Trader;

use App\Enum\UserTypeEnum;
use App\Models\purchasing;
use App\Models\UserReport;
use Illuminate\Http\Request;
use App\Enum\DeliveryWayEnum;
use App\Enum\PaymentTypeEnum;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Client\PurshaseCompanyRequest;
use App\Http\Requests\Api\V1\Client\PurshaseSupplierRequest;

class PurchasingController extends Controller
{
    use ApiResponseTrait;

    public function purshaseFromCompany(PurshaseCompanyRequest $request)
    {

        $data = $request->validated();
        if ($data['delivery_way'] == DeliveryWayEnum::ONSITE) {
            $total = $request->ton_quantity * $request->ton_quantity_cutting;

        } else {
            $total = $request->ton_quantity * $request->ton_quantity_cutting;
        }

        $company = Trader::findOrfail($request->trader_id);
        if ($company->company_balance < $total) {
            return $this->respondWithError('رصيد الدفتر غير كافي لتتم عملية الشراء');
        }


        $data['total'] = $total;
        $data['type'] = UserTypeEnum::COMPANY;
        $data['user_id'] = auth()->user()->id;
        $data['payment_way'] = 'cash';
        DB::beginTransaction();

        purchasing::create($data);

        $company->update(['company_balance' => $company->company_balance - $total]);
        auth()->user()?->financial()?->update(
            ['notebook_ton' => auth()->user()?->financial?->notebook_ton + $request->ton_quantity]
        );

        DB::commit();

        return $this->respondWithSuccess('تمت عملية الشراء من شركة بشكل ناجح');
    }

    public function purshaseFromSupplier(PurshaseSupplierRequest $request)
    {


        $data = $request->validated();
       
      
       $total = ($request->ton_quantity * $request->ton_quantity_cutting);
      // return $total;
        
     

        $supplier = Trader::findOrfail($request->trader_id);

        $data['total'] = $total;
        $data['type'] = UserTypeEnum::SUPPLIER;
        $data['user_id'] = auth()->user()->id;
        DB::beginTransaction();

        purchasing::create($data);


        if ($data['payment_way'] === PaymentTypeEnum::INSTALLMENT) {

            if ( ($total -  $data['first_amount']) >  $supplier?->credit_balance) {

                $supplier->update(['debit_balance' => $supplier?->debit_balance + ($total -  $data['first_amount']) -  $supplier?->credit_balance ,'credit_balance' => 0
                ]);


            }else{
                $supplier->update(['credit_balance' => $supplier?->credit_balance - $data['first_amount'] ,
                ]);

            }

            auth()->user()?->financial()?->update(
                ['notebook_ton' => auth()->user()?->financial?->notebook_ton + $request->ton_quantity,
                'notebook_balance' => $data['delivery_way'] == DeliveryWayEnum::ONSITE ?
                (auth()->user()->financial->notebook_balance - $data['first_amount']) :
                (auth()->user()->financial->notebook_balance - $data['first_amount'] - ($request->ton_quantity * $request->ton_colon_price)),
                ]
            );

        }

        elseif($data['payment_way'] === PaymentTypeEnum::CASH) {
            if (auth()->user()?->financial?->notebook_balance <    $total ) {
                return $this->respondWithError('رصيد الدفتر غير كافي لتتم عملية الشراء');
            }else{
            auth()->user()?->financial()?->update(
                [
                    'notebook_ton' => auth()->user()?->financial?->notebook_ton + $request->ton_quantity,
                    'notebook_balance' => $data['delivery_way'] == DeliveryWayEnum::ONSITE ?
                     auth()->user()->financial->notebook_balance - $total - ($request->ton_quantity * $request->ton_colon_price) :
                     auth()->user()->financial->notebook_balance - $total ,
                ]
            );
            

        }

        } 
         

        DB::commit();

        return $this->respondWithSuccess('تمت عملية الشراء من مورد بشكل ناجح');

        
    }
  

}
    
   