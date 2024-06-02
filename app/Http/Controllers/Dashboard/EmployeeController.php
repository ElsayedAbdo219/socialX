<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Trader;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Datatables\EmployeeDataTable;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use App\Enum\RegisterationRequestEnum;
use App\Http\Requests\Api\Auth\RegisterClientRequest;

class EmployeeController extends Controller
{
    use ApiResponseDashboard;

    protected string $datatable = EmployeeDataTable::class;
    protected string $route = 'admin.users';
    protected string $viewPath = 'dashboard.employees.list';


    public function index(){
     return $this->datatable::create($this->route)
        ->render($this->viewPath);
    }


    public function create(){
        return view('dashboard.employees.add');
        
    }

    public function store (RegisterClientRequest $request){
        $data = $request->validated();
        $data['type'] = UserTypeEnum::CLIENT;
        $data['is_Active'] = false;

        DB::beginTransaction();

        $Employee = Employee::create($data);

      

        Employee::create([
            'name' => UserTypeEnum::MAKHZANY,
            'phone' =>  $user->mobile,
            'user_id' => $user->id,
            'type' => UserTypeEnum::CLIENT,
        ]);

        DB::commit();
        return redirect()->route('admin.employees.index')->with(['success',__('dashboard.item added successfully')]);

        
    }

    public function edit ($Employee){
        $Employee=Employee::findOrFail($Employee);
        $statusArray = RegisterationRequestEnum::toArray();
        return view('dashboard.employees.edit',
        [
            'Employee'=>$Employee,
            'statusArray' => $statusArray,
        ]
    
    );
    }

    public function update(Request $request,$id){
        $Employee=Employee::findOrFail($id);
        
        $request->validate([
            'name'=>"required|string",
            'mobile'=>"required|string",
            'is_Active'=>"required|string",
        ]);
       
        $user->update([
            'name'=>$request->name,
            'mobile'=>$request->mobile,
            'is_Active'=>$request->is_Active,
        ]);
        return redirect()->route('admin.employees.index')->with(['success',__('dashboard.item updated successfully')]);

    }

    public function destroy(User $user)
    {
        $user->delete();
        if (request()->expectsJson()){
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.employees.index')->with('success',__('dashboard.item deleted successfully'));
    }


    
}
