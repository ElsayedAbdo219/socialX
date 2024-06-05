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
      //return auth('api')->user()->type ;

       if(auth('api')->user()->type === UserTypeEnum::COMPANY){
     
       
         $data= $request->validate([
                'comment' => 'nullable|string',
                'employee_id' => 'required',
                 "rate" => "required|numeric|min:1|max:5",
            ]);

            $data['company_id'] = auth('api')->user()->id;
    
            RateEmployee::create($data);
    
            return response()->json(['message' =>'تم اضافة تقيم بنجاح']);
       }

        $data= $request->validate([
               'comment' => 'nullable|string',
                'company_id' => 'required',
                "rate" => "required|numeric|min:1|max:5",
            ]);
            
       $data['employee_id'] = auth('api')->user()->id;
    
       RateCompany::create($data);

       return response()->json(['message' =>'تم اضافة تقيم بنجاح']);
          
    }


    # view rate for any company
    public function viewMyRate()
    {
      if (auth('api')->user()->type === UserTypeEnum::COMPANY){

        $myRates=RateEmployee::OfCompany(auth('api')->user()->id)->get();
        $total= $myRates?->count() > 0 ? $myRates->sum('rate') / $myRates?->count()  :  0 ;
   
       return response()->json([
           'rates'=>round($total,1),         
           'comments'=> $myRates->select('comment'),         
       
       ]);

      }

      $myRates=RateCompany::OfEmployee(auth('api')->user()->id)->get();

      $total= $myRates?->count() > 0 ? $myRates->sum('rate') / $myRates?->count()  :  0 ;
 
      return response()->json([
         'rates'=>round($total,1),         
         'comments'=> $myRates->select('comment'),         
    
      ]);
        
      
    }


   

}
