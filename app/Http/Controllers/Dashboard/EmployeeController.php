<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Member;
use App\Models\Trader;
use App\Models\Company;
use App\Models\Employee;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use App\Datatables\EmployeeDataTable;
use App\Enum\RegisterationRequestEnum;
use App\Http\Requests\Api\Auth\RegisterClientRequest;

class EmployeeController extends Controller
{
    use ApiResponseDashboard;

    protected string $datatable = EmployeeDataTable::class;
    protected string $route = 'admin.employees';
    protected string $viewPath = 'dashboard.employees.list';


    public function index(){
     return $this->datatable::create($this->route)
        ->render($this->viewPath);
    }


    public function create(){
        return view('dashboard.employees.add');
        
    }

    public function store (Request $request){
             $data=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'job' => 'required',
            'personal_photo' => 'image|mimes:jpeg,png,jpg',
            'personal_info' => 'string',
            'website' => 'url|string',
            'address' => 'string',
            'experience' => 'string',
            'coverletter' => 'image|mimes:jpeg,png,jpg',

       ]);
       

       $data['type']=UserTypeEnum::EMPLOYEE;

        $Employee = Member::create($data);


        if ($request->file('personal_photo')) {
            $file = $request->file('personal_photo');
            $personal_photo = uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('employees', $personal_photo);
             $Employee->update([
              'personal_photo'=> $personal_photo,
          ]);
        }

        if ($request->file('coverletter')) {
            $file = $request->file('coverletter');
            $coverletter = uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('employees', $coverletter);
             $Employee->update([
              'coverletter'=> $coverletter,
          ]);
        }


        return redirect()->route('admin.employees.index')->with(['success',__('dashboard.item added successfully')]);

        
    }

    public function edit ($Employee){
        $Employee=Member::findOrFail($Employee);
        $statusArray = RegisterationRequestEnum::toArray();
        return view('dashboard.employees.edit',
        [
            'Employee'=>$Employee,
            'statusArray' => $statusArray,
        ]
    
    );
    }

    public function update(Request $request,$id){
        $Employee=Member::findOrFail($id);
        
        $data=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'personal_photo' => 'image|mimes:jpeg,png,jpg',
            'personal_info' => 'string',
            'website' => 'url|string',
            'address' => 'string',
            'experience' => 'string',
            'coverletter' => 'image|mimes:jpeg,png,jpg',
            "is_Active" => "required|numeric|in:0,1",
        ]);

        $Employee->update($data);


        if ($request->file('personal_photo')) {
            $file = $request->file('personal_photo');
            $personal_photo = uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('employees', $personal_photo);
             $Employee->update([
              'personal_photo'=> $personal_photo,
          ]);
        }

        if ($request->file('coverletter')) {
            $file = $request->file('coverletter');
            $coverletter = uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('employees', $coverletter);
             $Employee->update([
              'coverletter'=> $coverletter,
          ]);
        }
       
        
        return redirect()->route('admin.employees.index')->with(['success',__('dashboard.item updated successfully')]);

    }

    public function destroy(Member $Employee)
    {
        $Employee->delete();
        if (request()->expectsJson()){
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.employees.index')->with('success',__('dashboard.item deleted successfully'));
    }


    
}
