<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Custody;
use App\Models\UserReport;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Client\CustodyResource;

class CustodyController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
       
        $custodies=Custody::ofUser(auth()->id())->get() ?? [];
        return CustodyResource::collection($custodies)->customPaginate(20);
    }

    public function custodyAction(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'to' => 'required|string|max:255',
            'reason' => 'required|string|max:255',

        ]);

        if(auth()->user()->financial?->drawer_balance > $data['amount']){

            Custody::create($data);
            auth()->user()->financial()->update([
                'drawer_balance' => auth()->user()->financial?->drawer_balance - $data['amount'],
            ]);

            return $this->respondWithSuccess('تمت اضافة العهدة بنجاح');
    
        }else{

            return $this->respondWithError("مبلغ العهدة يجب أن يكون اقل من رصيد الدرج ");
        }
      

       
    
        
    }


    public function equalTheCustodyAction(Request $request,Custody $custody)
    {

        $data = $request->validate([
            'equaltive_amount' => 'required|numeric',
            'to' => 'required|string|max:255',
        ]);
        if($data['equaltive_amount'] <= $custody->amount){

        Custody::find($custody->id)->update([
        'equaltive_amount'=>$data['equaltive_amount'],
        'status' =>'Active',
        'amount'=>$custody->amount  - $data['equaltive_amount'] 
     ]);

        auth()->user()->financial()->update([
            'drawer_balance' => auth()->user()->financial?->drawer_balance + $data['equaltive_amount'],
        ]);
        

        return $this->respondWithSuccess('تمت تسوية العهدة  بنجاح');

    }
    else{

        return $this->respondWithSuccess('لا يجب أن يكون مبلغ تسوية العهدة اكبر من مبلغ العهدة');
   }

}

}
