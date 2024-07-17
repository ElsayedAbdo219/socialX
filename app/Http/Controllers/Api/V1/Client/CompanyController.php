<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\UserReport;
use Illuminate\Http\Request;
use App\Enum\OperationTypeEnum;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\{DepositOperation, Trader,Member};
use App\Enum\{DepositTypeEnum, MoneyTypeEnum, UserTypeEnum};
use App\Http\Resources\Api\V1\Client\{TraderResource, DepositOperationResource};

class CompanyController extends Controller
{

    use ApiResponseTrait;



     public function index(){
        return response()->json(Member::where('is_Active', '1')
        ->where('type', UserTypeEnum::COMPANY)->with('posts','followersTotal','rateCompany','rateCompanyTotal','follower')->paginate(20));
    }

    public function indexofEmployee(){
        return response()->json(Member::where('is_Active', '1')
        ->where('type', UserTypeEnum::EMPLOYEE)->with('posts','experience','followersTotal','skills','position','education','rateEmployee','rateEmployeeTotal','follower')->paginate(20));
    }

     public function getJobs($id){
        return Member::where('id',$id)->with('jobs')->paginate(10);
    }





    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
        ], $request->all());
    

        $phones = Trader::OfUser(auth()->id())->pluck('phone')->toArray();

        if (in_array($request->phone, $phones)) {
            return $this->respondWithError('رقم التليفون موجود مسبقا');
        }
        
        $trader = Trader::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'user_id' => auth('api')->user()->id,
            'type' => UserTypeEnum::COMPANY,
        ]);
    
        return $this->respondWithArray(['data' => TraderResource::make($trader)]);
    }

    public function all()
    {
        $companies = Trader::ofType([UserTypeEnum::COMPANY])
            ->ofUser(auth()->id())->get();
        return $this->respondWithArray(['data' => TraderResource::collection($companies)]);
    }

    public function getSuppliersAndClients()
    {
        $traders = Trader::ofType([UserTypeEnum::CLIENT, UserTypeEnum::SUPPLIER])
            ->ofUser(auth()->id())->get();
        return $this->respondWithArray(['data' => TraderResource::collection($traders)]);
    }

    public function deposit(Request $request)
    {
      //   return $request;
         
        $request->validate([
            'deposit_type' => ['required'],
            'deposit_another_id' => ['required_if:deposit_type,' . DepositTypeEnum::ANOTHER_ACCOUNT->value],
            'trader_id' => ['required'],
            'amount' => ['required', 'numeric']
        ], $request->all());

        $company = Trader::findOrFail($request->trader_id);

        $data = $request->all();
        $data['type'] = MoneyTypeEnum::DEPOSIT->value;
        $data['deposit_operation_type'] = OperationTypeEnum::WHOLE;

        $user = auth()->user();

        DB::beginTransaction();
        if ($request->deposit_type == DepositTypeEnum::ANOTHER_ACCOUNT->value) {

            # From Another Account
            $anotherTrader = Trader::where('id', $request->deposit_another_id)
                ->ofType([UserTypeEnum::CLIENT, UserTypeEnum::SUPPLIER])->first();

            if (!$anotherTrader)
                return $this->respondWithError('المورد أو العميل غير موجود');

            if ($anotherTrader->credit_balance >= $request->amount) {
                $anotherTrader->update([
                    'credit_balance' => $anotherTrader->credit_balance - $request->amount
                ]);
            } else {
                $anotherTrader->update([
                    'debit_balance' => $anotherTrader->debit_balance +
                        ($request->amount - $anotherTrader->credit_balance),
                    'credit_balance' => 0
                ]);
            }
        } 
        else {   

            # From My Account
            if ($user->financial?->notebook_balance < (float)$request->amount) {
                return $this->respondWithError('الدفتر ليس لديه ما يكفي من المال');
            }
         //   return $request;
            $user->financial()->update([
                'notebook_balance' => $user->financial?->notebook_balance - $request->amount,
            ]);
          
        }

        DepositOperation::create($data);
        $company->company_balance += $request->amount;
        $company->push();


        DB::commit();

        return $this->respondWithSuccess('تمت عملية الايداع بنجاح');
    }

    public function settlement(Request $request)
    {
        $request->validate([
            'trader_id' => ['required'],
            'amount' => ['required', 'numeric']
        ], $request->all());

        $data = $request->all();
        $data['type'] = MoneyTypeEnum::SETTLEMENT->value;
        $data['deposit_operation_type'] = OperationTypeEnum::WHOLE;
        $data['deposit_type'] = '';

        $company = Trader::findOrFail($request->trader_id);

        DB::beginTransaction();
        DepositOperation::create($data);
        $company->company_balance += $request->amount;
        $company->push();
        DB::commit();

        return $this->respondWithSuccess('تمت عملية التسوية بنجاح');
    }

    public function getBalance(Trader $trader)
    {
        return $this->respondWithArray(['company_balance' => $trader->company_balance]);
    }

    public function getDepositAndSettlementOperations(Trader $trader, MoneyTypeEnum $type)
    {
        $depositOperations = $trader->depositOperation()->with('depositAnother')
            ->ofType($type)->get();
        return $this->respondWithArray([
            'data' => DepositOperationResource::collection($depositOperations)
        ]);
    }

    public function searchTrader(Request $request)
    {

        return Trader::query()->when($request->filled('keword'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->keword . '%')
            ->orwhere('phone', 'like', '%' . $request->keword . '%');
        })->ofUser(auth()->id())->get();
    }
}
