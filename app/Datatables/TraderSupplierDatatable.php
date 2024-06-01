<?php

namespace App\Datatables;

use Carbon\Carbon;
use App\Models\Trader;
use App\Models\GoodType;
use App\Enum\UserTypeEnum;
use Yajra\DataTables\Html\Column;
use Illuminate\Database\Eloquent\Builder;

class TraderSupplierDatatable extends BaseDatatable  {

    // protected ?string $actionable = 'edit';

    public function query(): Builder
    {
        return Trader::query(
        )->whereType(UserTypeEnum::SUPPLIER)->when(request('search')['value'], function ($q) {
            $q->ofName(request('search')['value']);
        })->with(['user'])->latest();
    }
    


 protected function getCustomColumns(): array
    {
        return [
            'name' => function ($model) {
                $title = $model->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'phone' => function ($model) {
                $title = $model->phone;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'createdBy' => function ($model) {
                $title = $model->user?->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'credit_balance' => function ($model) {
                $title = $model->credit_balance.' '.__('dashboard.pound');
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'debit_balance' => function ($model) {
                $title = $model->debit_balance.' '.__('dashboard.pound');
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            
        ];
    }

    protected function getColumns(): array
    {
        return [
            Column::computed('name')->title(__('dashboard.name'))->className('text-center'),
            Column::computed('phone')->title(__('dashboard.phone'))->className('text-center'),
            Column::computed('createdBy')->title(__('dashboard.dealWith'))->className('text-center'),
            Column::computed('credit_balance')->title(__('dashboard.credit_balance'))->className('text-center'),
            Column::computed('debit_balance')->title(__('dashboard.debit_balance'))->className('text-center'),
        ];
    }


}





?>