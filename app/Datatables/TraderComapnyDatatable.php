<?php

namespace App\Datatables;

use Carbon\Carbon;
use App\Models\Trader;
use App\Models\GoodType;
use App\Enum\UserTypeEnum;
use Yajra\DataTables\Html\Column;
use Illuminate\Database\Eloquent\Builder;

class TraderComapnyDatatable extends BaseDatatable  {

    // protected ?string $actionable = 'edit';

    public function query(): Builder
    {
        return Trader::query(
        )->whereType(UserTypeEnum::COMPANY)->when(request('search')['value'], function ($q) {
            $q->ofName(request('search')['value']);
        })->latest();
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

            'company_balance' => function ($model) {
                $title = $model->company_balance.' '.__('dashboard.pound');
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
            Column::computed('company_balance')->title(__('dashboard.company_balance'))->className('text-center'),
           
        ];
    }


}





?>