<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Datatables\TraderSupplierDatatable;
use App\Models\Trader;
use App\Enum\UserTypeEnum;
class TraderSupplierController extends Controller
{
    protected string  $datatable = TraderSupplierDatatable::class;
    protected string $route = 'admin.traders.suppliers';
    protected string $viewPath = 'dashboard.traders.suppliers.list';

    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }

    public function create()
    {
        return view('dashboard.traders.suppliers.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([ 'name' => 'required|string','phone'=> 'required|string']);
        Trader::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'user_id' => auth()->user()->id,
            'type' => UserTypeEnum::SUPPLIER,
        ]);
        return redirect()->route($this->route.'.'.'index')->with('success', __('dashboard.created_supplier'));
    }

    public function edit($trader){
        $trader=Trader::find($trader);

        return view('dashboard.traders.suppliers.edit',
        [
            'trader'=> $trader,
        ]

        );
    }


    public function update(Request $request,$company){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone'=> 'required|string',
            'credit_balance'=> 'required|numeric',
            'debit_balance'=> 'required|numeric',
        ]);
        $company=Trader::findOrfail($company);
        $company->update($data);
        return redirect()->route($this->route.'.'.'index')->with('success', __('dashboard.updated_supplier'));

    }


      public function delete($company){
        Trader::whereId($company)->delete();
        return redirect()->route($this->route.'.'.'index')->with('success', __('dashboard.deleted_supplier'));

    }


}
