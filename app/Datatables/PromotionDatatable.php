<?php

namespace App\Datatables;

use Carbon\Carbon;
use App\Models\Promotion;
use Yajra\DataTables\Html\Column;
use Illuminate\Database\Eloquent\Builder;

class PromotionDatatable extends BaseDatatable
{
    protected ?string $actionable = 'index|edit|delete';

    public function query(): Builder
    {
        return Promotion::query()->when(request('search')['value'],function ($q){
            $q->ofName(request('search')['value']);
        })->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'name' => function ($model) {
                $title = $model->name ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'discount' => function ($model) {
                $title = $model?->discount . '%';
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'start_date' => function ($model) {
                $title = \Carbon\Carbon::parse($model?->start_date)->translatedFormat('d M Y');
                return view('components.datatable.includes.columns.title', compact('title'));
            },
             'end_date' => function ($model) {
                $title = \Carbon\Carbon::parse($model?->end_date)->translatedFormat('d M Y');
                return view('components.datatable.includes.columns.title', compact('title'));
            },
           'active' => function ($model) {
            // dd($model?->is_active);
                $active = $model?->is_active;
            return view('components.datatable.includes.columns.active', compact('active'));
           },
        ];
    }

    protected function getColumns(): array
    {
        return [
            Column::computed('name')->title(__('dashboard.name'))->className('text-center'),
            Column::computed('discount')->title(__('dashboard.discount'))->className('text-center'),
            Column::computed('start_date')->title(__('dashboard.start_date'))->className('text-center'),
            Column::computed('end_date')->title(__('dashboard.end_date'))->className('text-center'),
            Column::computed('active')->title(__('dashboard.active'))->className('text-center'),
        ];
    }
}