<?php

namespace App\Datatables;

use Yajra\DataTables\Html\Column;
use App\Models\AdsPrice;
use Illuminate\Database\Eloquent\Builder;

class AdsPriceDatatable extends BaseDatatable
{
    protected ?string $actionable = 'edit';
    // edit // delete ?
    public function query(): Builder
    {
        return AdsPrice::query()->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'price' => function ($model) {
                $title = $model?->price;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'currency' => function ($model) {
                $title = $model?->currency;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'resolution' => function ($model) {
                $title = $model?->resolution;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'type' => function ($model) {
                $title = $model?->type;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'created_at' => function ($model) {
                $title = $model?->created_at;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
           
        ];
    }
  
    protected function getColumns(): array
    {
        return [
            Column::computed('price')->title(__('dashboard.price'))->className('text-center'),
            Column::computed('currency')->title(__('dashboard.currency'))->className('text-center'),
            Column::computed('resolution')->title(__('dashboard.resolution'))->className('text-center'),
            Column::computed('type')->title(__('dashboard.type'))->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),

        ];
    }


}
