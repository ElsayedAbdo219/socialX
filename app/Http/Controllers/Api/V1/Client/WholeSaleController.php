<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Trader;
use App\Models\WholeSale;
use App\Enum\UserTypeEnum;
use App\Models\UserReport;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Enum\DeliveryWayEnum;
use App\Enum\PaymentTypeEnum;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\ClientNotification;
use App\Http\Requests\Api\V1\Client\WholeSaleRequest;

class WholeSaleController extends Controller
{

   use ApiResponseTrait;

   # بيع جملة
   public function save(WholeSaleRequest $request)
   {

      $data = $request->validated();


    $total = ($request->ton_quantity * $request->ton_quantity_price);

      $supplier = Trader::findOrFail($request->trader_id);

      $data['total'] = $total;

      DB::beginTransaction();


      $whole=WholeSale::create($data);


      $leftTotal = $data['payment_type'] === PaymentTypeEnum::INSTALLMENT ? $total -  $data['first_amount'] : 0 ;
      // return $leftTotal;
 // 9000

      if ($data['payment_type'] === PaymentTypeEnum::INSTALLMENT) {



         if ($leftTotal  >= $supplier->debit_balance && $leftTotal  > 0 ) {

             $supplier->credit_balance += ($leftTotal - $supplier->debit_balance);
             $supplier->debit_balance = 0;

         } elseif($leftTotal  >= $supplier->debit_balance && $leftTotal  < 0 ){
            $supplier->debit_balance += ( 0 - $leftTotal);

         }elseif ($leftTotal  <= $supplier->debit_balance) {

             $supplier->debit_balance -= $leftTotal;
         }


          auth()->user()->financial()->update([
            'notebook_balance' => $data['delivery_way'] == DeliveryWayEnum::ONSITE ?
                (auth()->user()->financial->notebook_balance + $data['first_amount']) :
                (auth()->user()->financial->notebook_balance + $data['first_amount'] - ($request->ton_quantity * $request->ton_nolon_price)),
            'notebook_ton' => auth()->user()->financial->notebook_ton - $request->ton_quantity,
          ]);
          

          

             if ($supplier->name == UserTypeEnum::MAKHZANY) {

            if($data['first_amount'] < auth()->user()->financial->drawer_balance ){

                if($leftTotal >= $supplier->debit_balance && $leftTotal  > 0 ){
                    $supplier->debit_balance_sectoral += ($leftTotal - $supplier->debit_balance);
                }

                elseif($leftTotal >= $supplier->debit_balance && $leftTotal  < 0 ){
                  $supplier->debit_balance_sectoral += ( 0 - $leftTotal) ;
                }

                elseif ($leftTotal  <= $supplier->debit_balance) {

                    $supplier->credit_balance_sectoral += ($leftTotal - $supplier->debit_balance);
                    $supplier->debit_balance_sectoral = 0;
                }

                auth()->user()->financial()->update([
                    'drawer_balance' => auth()->user()->financial->drawer_balance - $data['first_amount'],
                    'drawer_ton' => auth()->user()->financial->drawer_ton + $request->ton_quantity,
                ]);

            }else{
                return $this->respondWithError("ميزانية الدرج اقل من المبلغ المراد بيعه");
            }



         }


         $supplier->save();

     }
     elseif($data['payment_type'] === PaymentTypeEnum::CASH) {

         if ($supplier->name === UserTypeEnum::MAKHZANY) {
            if( auth()->user()->financial->drawer_balance < $total){
                return $this->respondWithError("الكمية المراد بيعها اكبر من ميزانية الدرج");
            }
              else{
                auth()->user()->financial()->update([
                    'drawer_balance' => auth()->user()->financial->drawer_balance - $total,
                    'drawer_ton' => auth()->user()->financial->drawer_ton + $request->ton_quantity,
                ]);

              }

         }
             auth()->user()->financial()->update([
                 'notebook_balance' =>$data['delivery_way'] == DeliveryWayEnum::ONSITE ? auth()->user()->financial->notebook_balance + $total :auth()->user()->financial->notebook_balance + $total - ($request->ton_quantity * $request->ton_nolon_price) ,
                 'notebook_ton' => auth()->user()->financial->notebook_ton - $request->ton_quantity,
             ]);



     }



      DB::commit();


       if (auth()->user()->financial->notebook_ton < 0 ){
        $notifabels = $whole->user;
        $notificationData = [
        'title' => __('dashboard.warning'),
        'body' => __('dashboard.current ton quantity of notebook is less than had selled'),
        ];

        # sending a notification to the user
         \Illuminate\Support\Facades\Notification::send($notifabels,
         new ClientNotification($notificationData, ['database', 'firebase']));

          }


      return $this->respondWithSuccess('تمت عملية البيع جملة بشكل ناجح');
   }
}
