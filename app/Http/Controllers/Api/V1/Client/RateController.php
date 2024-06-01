<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\{
  Rate,
  RateCompany,
  RateEmployee,
};


use App\Enums\UserTypeEnum;
class RateController extends Controller
{
    public function addFromCompany(Request $request)
    {
           $data= $request->validate([
                'name' => 'required|string|max:255',
                'employee_id' => 'required',
            ]);

            $data['company_id']=auth()->user()->id;
    
            RateEmployee::create($data);
    
            return response()->json(['message' =>'Rate Addde by Company Successfully']);
      
    }

      public function addFromEmployee(Request $request)
    {
           $data= $request->validate([
                'name' => 'required|string|max:255',
                'employee_id' => 'required',
            ]);

            $data['company_id']=auth()->user()->id;
    
            RateCompany::create($data);
    
            return response()->json(['message' =>'Rate Addde by Employee Successfully']);
      
    }


    # view rate for any company
    public function viewMyRate($type)
    {
      if ($type == UserTypeEnum::COMPANY){

        $myRates=RateCompany::OfCompany(auth()->user()->id)->get(['rate']);
        $total= $myRates->sum('rate') / $myRates->count();
   
       return response()->json([
           'rates'=> $total,         
           'ratesFormatted'=>round($total,0),         
       
       ]);
      }

      $myRates=RateEmployee::OfEmployee(auth()->user()->id)->get(['rate']);
      $total= $myRates->sum('rate') / $myRates->count();
 
     return response()->json([
         'rates'=> $total,         
         'ratesFormatted'=>round($total,0),         
     
     ]);
        
      
    }



}
