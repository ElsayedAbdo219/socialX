<?php

namespace App\Http\Controllers\Dashboard;
use Illuminate\Http\Request;
use App\Models\FinancialUser;

use App\Datatables\DrawerDatatable;
use App\Http\Controllers\Controller;

class DrawerController extends Controller
{
    protected string $datatable = DrawerDatatable::class;
    protected string $route = 'admin.drawer';
    protected string $viewPath = 'dashboard.drawer.list';

    
    public function getDrawerBalance()
    {
        return $this->datatable::create($this->route)
        ->render($this->viewPath);

    }


    public function edit($drawer)
    {
      $drawer=FinancialUser::findOrFail($drawer);
      return view(
        "dashboard.drawer.edit",
        [
          "drawer" => $drawer,
        ]
      );
    }
  
    public function update(Request $request, $drawer)
    {
      $drawer=FinancialUser::findOrFail($drawer);
      $request->validate([
          'drawer_balance'=>"required|string",
          'drawer_ton'=>"required|string",
      ]);
     
      $drawer->update([
          'drawer_balance'=>$request->drawer_balance,
          'drawer_ton'=>$request->drawer_ton,
      ]);
      return redirect()->route('admin.drawer.index')->with(['success',__('dashboard.item updated successfully')]);
      
    }

}
