<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use Illuminate\Support\Facades\Auth;
use App\Enum\RegisterationRequestEnum;
use App\Http\Requests\Dashboard\LoginRequest;
use App\Datatables\RegisterationRequestsDataTable;

class UnActiveUserController extends Controller
{
    use ApiResponseDashboard;

    protected string $datatable = RegisterationRequestsDataTable::class;
    protected string $route = 'admin.registration_requests';
    protected string $viewPath = 'dashboard.RegisterationRequests.list';


    public function index()
    {
        return $this->datatable::create($this->route)
        ->render($this->viewPath);
    }



    public function edit($id)
    {

        $statusArray = RegisterationRequestEnum::toArray();
        $RegisterationRequest = User::findOrFail($id);
        return view('dashboard.RegisterationRequests.edit', [
            'RegisterationRequest' => $RegisterationRequest,
            'statusArray' => $statusArray,
        ]);
    }


    // changeStatus
    public function update(Request $request,$id)
    {
        $RegisterationRequestData = User::find($id);
        if($request->status != RegisterationRequestEnum::DISACTIVE){
            $RegisterationRequestData->update(['is_active' => RegisterationRequestEnum::ACTIVE]);
            return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.the status has been updated successfully'));
        }

          return redirect()->route($this->route . '.' . 'index');

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
