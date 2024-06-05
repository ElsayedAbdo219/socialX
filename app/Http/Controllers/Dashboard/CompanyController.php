<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Member;
use App\Models\Trader;
use App\Models\Company;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Datatables\CompanyDataTable;
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

    public function store (Request $request){
             $data=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg',
            'slogo' => 'string',
            'website' => 'url|string',
            'address' => 'string',
            'bio' => 'string',
       ]);

        $Company = Member::create($data);


        if ($request->file('logo')) {
            $file = $request->file('logo');
            $logo = uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('companies', $logo);
             $Company->update([
              'logo'=> $logo,
          ]);
        }
        return redirect()->route('admin.companies.index')->with(['success',__('dashboard.item added successfully')]);

        
    }

    public function edit ($Company){
        $Company=Member::findOrFail($Company);
        $statusArray = RegisterationRequestEnum::toArray();
        return view('dashboard.companies.edit',
        [
            'Company'=>$Company,
            'statusArray' => $statusArray,
        ]
    
    );
    }

    public function update(Request $request,$id){
        $Company=Member::findOrFail($id);
        
        $data=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg',
            'slogo' => 'string',
            'website' => 'url|string',
            'address' => 'string',
            'bio' => 'string',
            "is_Active" => "required|numeric|in:0,1",
        ]);

        $Company->update($data);


        if ($request->file('logo')) {
            $file = $request->file('logo');
            $logo = uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('companies', $logo);
             $Company->update([
              'logo'=> $logo,
          ]);
        }
       
        
        return redirect()->route('admin.companies.index')->with(['success',__('dashboard.item updated successfully')]);

    }

    public function destroy(Member $Company)
    {
        $Company->delete();
        if (request()->expectsJson()){
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.companies.index')->with('success',__('dashboard.item deleted successfully'));
    }


    
}
