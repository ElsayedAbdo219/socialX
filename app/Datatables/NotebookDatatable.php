<?php

namespace App\Datatables;

use App\Enum\UserTypeEnum;
use App\Models\GoodType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;
use App\Models\FinancialUser;
class NotebookDatatable extends BaseDatatable  {

     protected ?string $actionable = 'index|edit';

    public function query(): Builder
    {
        return FinancialUser::query(
        )->when(request('search')['value'], function ($q) {
            $q->OfCreated(request('search')['value']);
        })->latest();
    }

 protected function getCustomColumns(): array
    {
        return [
            'notebook_balance' => function ($model) {
                $title = $model->notebook_balance.' '.__('dashboard.pound');
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'notebook_ton' => function ($model) {
                $title = $model->notebook_ton;
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
            Column::computed('notebook_balance')->title(__('dashboard.notebook_balance'))->className('text-center'),
            Column::computed('notebook_ton')->title(__('dashboard.notebook_ton'))->className('text-center'),
            Column::computed('userName')->title(__('dashboard.userName'))->className('text-center'),
            Column::computed('userPhone')->title(__('dashboard.userPhone'))->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),
           
        ];
    }


}





?>