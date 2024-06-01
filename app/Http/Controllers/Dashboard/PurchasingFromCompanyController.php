<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PurshaseCompanyRequest;
use App\Http\Requests\Dashboard\PurshaseSupplierRequest;
use App\Datatables\PurchasingFromCompanyDatatable;
use App\Models\Trader;
use App\Enum\UserTypeEnum;
use App\Models\purchasing;
use App\Models\GoodType;
use Illuminate\Http\Request;
use App\Enum\DeliveryWayEnum;
use Illuminate\Support\Facades\DB;

class PurchasingFromCompanyController extends Controller
{
    protected string  $datatable = PurchasingFromCompanyDatatable::class;
    protected string $route = 'admin.purshasefromcomaies';
    protected string $viewPath = 'dashboard.purshasingFrom.companies.list';

    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }


    public function create()
    {
        $traders = Trader::whereType(UserTypeEnum::COMPANY)->get();
        $goodsTypes = GoodType::all();
        return view(
            'dashboard.purshasingFrom.companies.add',
            [
                'traders' => $traders,
                'goodsTypes' => $goodsTypes,
            ]

        );

      
    }

    public function purshaseFromCompany(PurshaseCompanyRequest $request){
        $data=$request->validated();
        if($data['delivery_way'] == DeliveryWayEnum::ONSITE){
           $total = $request->ton_quantity * $request->ton_quantity_cutting;
        }
        else{
           $total = ($request->ton_quantity * $request->ton_quantity_cutting) + 
           ($request->ton_quantity * $request->ton_colon_price);
         
        }
   
        $company = Trader::findOrfail($request->trader_id);
        if($company->company_balance < $total){

             return redirect()->route('purshasefromcomaies')->with(['error',__('messages.not enough balance')]);
        }
   
        $data['total'] = $total;
        $data['type'] = UserTypeEnum::COMPANY;
        $data['user_id'] = auth()->user()->id;
        $data['payment_way'] = ' ';
        DB::beginTransaction();
   
        purchasing::create($data);
        
        $company->update(['company_balance' => $company->company_balance - $total]);
        auth()->user()?->financial()?->update(
           ['notebook_ton' => auth()->user()?->financial?->notebook_ton + $request->ton_quantity]
       );
   
        DB::commit();
   
        return redirect()->route('purshasefromcomaies')->with(['success',__('messages.purshase from company added successfully')]);

       }
      
   
}
