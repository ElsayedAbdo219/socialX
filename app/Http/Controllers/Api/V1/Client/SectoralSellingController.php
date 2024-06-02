<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Trader;

use App\Enum\UserTypeEnum;
use App\Models\UserReport;
use Illuminate\Http\Request;
use App\Enum\DeliveryWayEnum;
use App\Enum\PaymentTypeEnum;
use App\Models\SectoralSelling;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\ClientNotification;
use App\Http\Requests\Api\V1\Client\SectoralSellingRequest;

class SectoralSellingController extends Controller
{
  use ApiResponseTrait;


  # بيع قطاعي
  public function save(SectoralSellingRequest $request)
  {
    
    $data = $request->validated();
    //return $data;

    if ($data['delivery_way'] == DeliveryWayEnum::ONSITE) {
      $total = ($request->quantity * $request->unit_price);
   } else {
      $total = ($request->quantity * $request->unit_price) + $request->ton_nolon_price;
   }

   $data['total'] = $total;


    DB::beginTransaction();
 
   // $data['quantity']=$request->unit == 'shikara' ? $data['quantity'] / 20 :  $data['quantity'] ;


    $leftTotal = $data['payment_type'] === PaymentTypeEnum::CHECKINGACCOUNT ? $total -  $data['payment_amout'] : 0 ;


    $serctoral = SectoralSelling::create($data);

    if ($data['payment_type'] === PaymentTypeEnum::CHECKINGACCOUNT) {
      
      $supplier = Trader::findOrFail($request->trader_id);
  
     
      if ($leftTotal > $supplier->debit_balance_sectoral && $leftTotal  > 0  ) {
          $supplier->credit_balance_sectoral += ($leftTotal - $supplier->debit_balance_sectoral);
          $supplier->debit_balance_sectoral = 0;
      }

      elseif ($leftTotal > $supplier->debit_balance_sectoral && $leftTotal  < 0  ) {
        $supplier->debit_balance_sectoral += (0-$leftTotal);
     
    }
      
      elseif ($leftTotal < $supplier->debit_balance_sectoral) {
          $supplier->debit_balance_sectoral -= $leftTotal;
      }
      
      
         $supplier->save();

         $userFinancial = auth()->user()->financial;
      
         if(  $data['total'] > $data['payment_amout'] ){
     
            $userFinancial->drawer_balance = $userFinancial->drawer_balance +  $data['payment_amout'] -  $request->ton_nolon_price;
             $userFinancial->drawer_ton = $data['unit'] == "shikara" ? $userFinancial->drawer_ton - ($data['quantity'] / 20) : $userFinancial->drawer_ton - $data['quantity']   ; 
            
            
         }else{
            $userFinancial->drawer_balance = $userFinancial->drawer_balance +  $data['total'] - $request->ton_nolon_price;
            $userFinancial->drawer_ton =  $data['unit'] == "shikara" ? $userFinancial->drawer_ton - ($data['quantity'] / 20) : $userFinancial->drawer_ton - $data['quantity']   ; 

         }
//$request->unit == 'shikara' 
         $userFinancial->save();

  }
  
    
  elseif ($data['payment_type'] === PaymentTypeEnum::CASH) {
    $userFinancial = auth()->user()->financial;
    if ($userFinancial) {
      
        $newDrawerBalance = $userFinancial->drawer_balance + $data['total'] -  $request->ton_nolon_price;
        $newDrawerTon =  $data['unit'] == "shikara" ? $userFinancial->drawer_ton - ($data['quantity'] / 20) : $userFinancial->drawer_ton - $data['quantity']   ; 

        
        $userFinancial->update([
            'drawer_balance' => $newDrawerBalance,
            'drawer_ton' => $newDrawerTon,
        ]);

    }
}


    DB::commit();

    if (auth()->user()->financial->drawer_ton < 0 ){
      $notifabels = $serctoral->user;
      $notificationData = [
      'title' => __('dashboard.warning'),
      'body' => __('dashboard.current ton quantity of drawer is less than had selled'),
      ];
     
      # sending a notification to the user
       \Illuminate\Support\Facades\Notification::send($notifabels,
       new ClientNotification($notificationData, ['database', 'firebase']));
       
        }
    

    return $this->respondWithSuccess('تمت عملية البيع القطاعي بشكل ناجح');
}

}
// delete credit and debit from traders table 
// create sail_details table
// sail_details consists from id , trader_id , type , credit_balance , debit_balance 
