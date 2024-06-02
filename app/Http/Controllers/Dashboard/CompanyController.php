<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Trader;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Datatables\CompanyDataTable;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use App\Enum\RegisterationRequestEnum;
use App\Http\Requests\Api\Auth\RegisterClientRequest;

class CompanyController extends Controller
{
    use ApiResponseDashboard;

    protected string $datatable = CompanyDataTable::class;
    protected string $route = 'admin.companies';
    protected string $viewPath = 'dashboard.companies.list';


    public function index(){
     return $this->datatable::create($this->route)
        ->render($this->viewPath);
    }


    public function create(){
        return view('dashboard.companies.add');
        
    }

    public function store (قequest $request){
             $data=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'logo' => 'image,mimes:jpeg,png,jpg',
            'slogo' => 'string',
            'website' => 'url|string',
            'address' => 'string',
            'bio' => 'string',
       ]);

        $Company = Company::create($data);

        return redirect()->route('admin.companies.index')->with(['success',__('dashboard.item added successfully')]);

        
    }

    public function edit ($Company){
        $Company=Company::findOrFail($Company);
        $statusArray = RegisterationRequestEnum::toArray();
        return view('dashboard.companies.edit',
        [
            'Company'=>$Company,
            'statusArray' => $statusArray,
        ]
    
    );
    }

    public function update(Request $request,$id){
        $user=User::findOrFail($id);
        
        $request->validate([
            'name'=>"required|string",
            'is_Active'=>"required|string",
        ]);
       
        $user->update([
            'name'=>$request->name,
            'mobile'=>$request->mobile,
            'is_Active'=>$request->is_Active,
        ]);
        return redirect()->route('admin.companies.index')->with(['success',__('dashboard.item updated successfully')]);

    }

    public function destroy(User $user)
    {
        $user->delete();
        if (request()->expectsJson()){
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.companies.index')->with('success',__('dashboard.item deleted successfully'));
    }


    
}
