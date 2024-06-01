<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Trader;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Datatables\UserDataTable;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use App\Enum\RegisterationRequestEnum;
use App\Http\Requests\Api\Auth\RegisterClientRequest;

class UserController extends Controller
{
    use ApiResponseDashboard;

    protected string $datatable = UserDataTable::class;
    protected string $route = 'admin.users';
    protected string $viewPath = 'dashboard.users.list';


    public function index(){
     return $this->datatable::create($this->route)
        ->render($this->viewPath);
    }


    public function create(){
        return view('dashboard.users.add');
        
    }

    public function store (RegisterClientRequest $request){
        $data = $request->validated();
        $data['type'] = UserTypeEnum::CLIENT;
        $data['is_active'] = false;

        DB::beginTransaction();

        $user = User::create($data);

        $user->financial()->create([]);

        Trader::create([
            'name' => UserTypeEnum::MAKHZANY,
            'phone' =>  $user->mobile,
            'user_id' => $user->id,
            'type' => UserTypeEnum::CLIENT,
        ]);

        DB::commit();
        return redirect()->route('admin.users.index')->with(['success',__('dashboard.item added successfully')]);

        
    }

    public function edit ($user){
        $user=User::findOrFail($user);
        $statusArray = RegisterationRequestEnum::toArray();
        return view('dashboard.users.edit',
        [
            'user'=>$user,
            'statusArray' => $statusArray,
        ]
    
    );
    }

    public function update(Request $request,$id){
        $user=User::findOrFail($id);
        
        $request->validate([
            'name'=>"required|string",
            'mobile'=>"required|string",
            'is_active'=>"required|string",
        ]);
       
        $user->update([
            'name'=>$request->name,
            'mobile'=>$request->mobile,
            'is_active'=>$request->is_active,
        ]);
        return redirect()->route('admin.users.index')->with(['success',__('dashboard.item updated successfully')]);

    }

    public function destroy(User $user)
    {
        $user->delete();
        if (request()->expectsJson()){
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.users.index')->with('success',__('dashboard.item deleted successfully'));
    }


    
}
