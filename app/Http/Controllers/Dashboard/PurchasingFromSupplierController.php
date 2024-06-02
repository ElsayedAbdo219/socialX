<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PurshaseCompanyRequest;
use App\Http\Requests\Dashboard\PurshaseSupplierRequest;
use App\Models\Trader;
use App\Enum\UserTypeEnum;
use App\Models\purchasing;
use App\Models\GoodType;
use Illuminate\Http\Request;
use App\Enum\DeliveryWayEnum;
use Illuminate\Support\Facades\DB;

use App\Datatables\PurchasingFromSupplierDatatable;

class PurchasingFromSupplierController extends Controller
{
    protected string  $datatable = PurchasingFromSupplierDatatable::class;
    protected string $route = 'admin.purshasefromsuppliers';
    protected string $viewPath = 'dashboard.purshasingFrom.suppliers.list';

    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }


    public function create()
    {
        $traders = Trader::whereType(UserTypeEnum::SUPPLIER)->get();
        $goodsTypes = GoodType::all();
        return view(
            'dashboard.purshasingFrom.suppliers.add',
            [
                'traders' => $traders,
                'goodsTypes' => $goodsTypes,
            ]

        );

    }
   
       public function purshaseFromSupplier(PurshaseSupplierRequest $request){
          
           $data=$request->validated();
           if($data['delivery_way'] == DeliveryWayEnum::ONSITE ){
              $total = ($request->ton_quantity * $request->ton_quantity_cutting)  ;
           }
           else{
              $total = ($request->ton_quantity * $request->ton_quantity_cutting) + 
              ($request->ton_quantity * $request->ton_colon_price);
            
           }
      
           $supplier = Trader::findOrfail($request->trader_id);
           if($supplier->credit_balance < $total){
             //edited to blade  return $this->respondWithError('messages.not enough balance');

           }
      
           $data['total'] = $total;
           $data['type'] = UserTypeEnum::SUPPLIER;
           $data['user_id'] = auth()->user()->id;
           DB::beginTransaction();
      
           purchasing::create($data);
           
           $supplier->update(['credit_balance' => $supplier->credit_balance - $total]);
           auth()->user()?->financial()?->update(
              ['notebook_ton' => auth()->user()?->financial?->notebook_ton + $request->ton_quantity]
          );
      
           DB::commit();
      
           return redirect()->route('purshasefromsuppliers')->with(['success',__('messages.purshase from SUPPLIER added successfully')]);
       }
}
