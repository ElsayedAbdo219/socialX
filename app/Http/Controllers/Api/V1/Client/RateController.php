<?php

namespace App\Http\Controllers\Api\V1\Client;

use Illuminate\Http\Request;
use App\Models\{
  Rate,
  RateCompany,
  RateEmployee,
};
use App\Http\Controllers\Controller;

use App\Enum\UserTypeEnum;

class RateController extends Controller
{

    public function add(Request $request)
    {

       if(auth('api')->user()->type === UserTypeEnum::COMPANY){
       
         $data= $request->validate([
                'comment' => 'nullalbe|string',
                'employee_id' => 'required',
            ]);

            $data['company_id'] = auth('api')->user()->id;
    
            RateEmployee::create($data);
    
            return response()->json(['message' =>'Rate Addde by Company Successfully']);
       }

        $data= $request->validate([
                'comment' => 'nullalbe|string',
                'company_id' => 'required',
            ]);
            
       $data['employee_id'] = auth('api')->user()->id;
    
       RateEmployee::create($data);

       return response()->json(['message' =>'Rate Addde by Company Successfully']);
          
    }


    # view rate for any company
    public function viewMyRate()
    {
      if (auth('api')->user()->type === UserTypeEnum::COMPANY){

        $myRates=RateCompany::OfCompany(auth()->user()->id)->get(['rate']);
        $total= $myRates->sum('rate') / $myRates->count();
   
       return response()->json([
           'rates'=> $total,         
           'ratesFormatted'=>round($total,1),         
       
       ]);
      }

      $myRates=RateEmployee::OfEmployee(auth()->user()->id)->get(['rate']);
      $total= $myRates->sum('rate') / $myRates->count();
 
     return response()->json([
         'rates'=> $total,         
         'ratesFormatted'=>round($total,1),         
     
     ]);
        
      
    }



}
