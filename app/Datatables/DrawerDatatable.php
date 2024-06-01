<?php

namespace App\Datatables;

use App\Enum\UserTypeEnum;
use App\Models\GoodType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;
use App\Models\FinancialUser;
class DrawerDatatable extends BaseDatatable  {

    protected ?string $actionable = 'index|edit';

     public function query(): Builder
    {
        return FinancialUser::query(
        )->when(request('search')['value'], function ($q) {
            $q->ofCreated(request('search')['value']);
        })->latest();
    }


 protected function getCustomColumns(): array
    {
        return [
            'drawer_balance' => function ($model) {
                $title = $model->drawer_balance.' '.__('dashboard.pound');
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'drawer_ton' => function ($model) {
                $title = $model->drawer_ton;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'userName' => function ($model) {
                $title = $model->user?->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'userPhone' => function ($model) {
                $title = $model->user?->mobile;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'created_at' => function ($model) {
                $title = $model->created_at;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            
        ];
    }

    protected function getColumns(): array
    {
        return [
            Column::computed('drawer_balance')->title(__('dashboard.drawer_balance'))->className('text-center'),
            Column::computed('drawer_ton')->title(__('dashboard.drawer_ton'))->className('text-center'),
            Column::computed('userName')->title(__('dashboard.userName'))->className('text-center'),
            Column::computed('userPhone')->title(__('dashboard.userPhone'))->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),
           
        ];
    }


}





?>