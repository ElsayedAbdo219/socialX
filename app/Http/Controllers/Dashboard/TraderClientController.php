<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Datatables\TraderClientDatatable;
use App\Models\Trader;
use App\Enum\UserTypeEnum;
class TraderClientController extends Controller
{
    protected string  $datatable = TraderClientDatatable::class;
    protected string $route = 'admin.traders.clients';
    protected string $viewPath = 'dashboard.traders.clients.list';

    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }



    public function create()
    {
        return view('dashboard.traders.clients.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([  'name' => 'required|string|max:255','phone'=> 'required|string']);
        Trader::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'user_id' => auth()->user()->id,
            'type' => UserTypeEnum::CLIENT,
        ]);
              return redirect()->route($this->route.'.'.'index')->with('success', __('dashboard.created_client'));

    }

    public function edit($trader){
        $trader=Trader::find($trader);

        return view('dashboard.traders.clients.edit',
        [
            'trader'=> $trader,
        ]

        );
    }

    public function update(Request $request,$Trader){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone'=> 'required|string',
            'credit_balance'=> 'required|numeric',
            'debit_balance'=> 'required|numeric',
        ]);
        $Trader=Trader::findOrfail($Trader);
        $Trader->update($data);
        return redirect()->route($this->route.'.'.'index')->with('success', __('dashboard.updated_client'));

    }


      public function delete($Trader){
        Trader::whereId($Trader)->delete();
        return redirect()->route($this->route.'.'.'index')->with('success', __('dashboard.deleted_client'));

    }

}
