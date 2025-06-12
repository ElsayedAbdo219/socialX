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
            'status' => function ($model) {
                $title = !empty($model->days_count) ? "<span style='color:blue;font-family:cairo; font-size:20px;'>".__('dashboard.with_days_number')."</span>" : "<span style='color:red;font-family:cairo; font-size:20px;'>".__('dashboard.with_period')."</span>" ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
              'start_date' => function ($model) {
                $title = !empty($model->start_date) ? \Carbon\Carbon::parse($model->start_date)->format('Y-m-d') : '' ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
              'end_date' => function ($model) {
                $title = !empty($model->end_date) ? \Carbon\Carbon::parse($model->end_date)->format('Y-m-d') : '' ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'days_count' => function ($model) {
                $title = $model->days_count ?? '' ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'discount' => function ($model) {
                $title = $model?->discount . '%';
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
            Column::computed('status')->title(__('dashboard.status'))->className('text-center'),
            Column::computed('start_date')->title(__('dashboard.start_date'))->className('text-center'),
            Column::computed('end_date')->title(__('dashboard.end_date'))->className('text-center'),
            Column::computed('days_count')->title(__('dashboard.days_count'))->className('text-center'),
            Column::computed('discount')->title(__('dashboard.discount'))->className('text-center'),
            Column::computed('active')->title(__('dashboard.active'))->className('text-center'),
        ];
    }
}