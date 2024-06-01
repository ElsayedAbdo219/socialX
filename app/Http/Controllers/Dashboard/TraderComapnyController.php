<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Trader;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Datatables\TraderComapnyDatatable;

class TraderComapnyController extends Controller
{
    protected string  $datatable = TraderComapnyDatatable::class;
    protected string $route = 'admin.traders.companies';
    protected string $viewPath = 'dashboard.traders.companies.list';

    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }


    public function create()
    {
        return view('dashboard.traders.companies.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone'=> 'required|string',
        ]);
        Trader::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'user_id' => auth()->user()->id,
            'type' => UserTypeEnum::COMPANY,
        ]);
        return redirect()->route($this->route.'.'.'index')->with('success', __('dashboard.created_company'));
    }

    public function edit($trader){
        $trader=Trader::find($trader);

        return view('dashboard.traders.companies.edit',
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
        return redirect()->route($this->route.'.'.'index')->with('success', __('dashboard.updated_company'));

    }


      public function delete($company){
        Trader::whereId($company)->delete();
        return redirect()->route($this->route.'.'.'index')->with('success', __('dashboard.deleted_company'));

    }



}
