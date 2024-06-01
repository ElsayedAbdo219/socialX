<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Datatables\NotebookDatatable;
use App\Models\FinancialUser;
use Illuminate\Http\Request;

class NotebookController extends Controller
{
  protected string $datatable = NotebookDatatable::class;
  protected string $route = 'admin.notebook';
  protected string $viewPath = 'dashboard.notebook.list';


  public function getNotebookBalance()
  {
    //  return FinancialUser::select('id','notebook_balance','notebook_ton','created_at')->orderBy('id','desc')->get();


    return $this->datatable::create($this->route)
      ->render($this->viewPath);
  }

  public function edit($notebook)
  {
    $notebook=FinancialUser::findOrFail($notebook);
    return view(
      "dashboard.notebook.edit",
      [
        "notebook" => $notebook,
      ]
    );
  }

  public function update(Request $request, $notebook)
  {
    $notebook=FinancialUser::findOrFail($notebook);
    $request->validate([
        'notebook_balance'=>"required|string",
        'notebook_ton'=>"required|string",
    ]);
   
    $notebook->update([
        'notebook_balance'=>$request->notebook_balance,
        'notebook_ton'=>$request->notebook_ton,
    ]);
    return redirect()->route('admin.notebook.index')->with(['success',__('dashboard.item updated successfully')]);
    
  }
}
