<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Datatables\TransactionTypeDatatable;

class TransactionController extends Controller
{

    protected string  $datatable = TransactionTypeDatatable::class;
    protected string $route = 'admin.Transactions';
    protected string $viewPath = 'dashboard.Transactions.list';

    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }
}
