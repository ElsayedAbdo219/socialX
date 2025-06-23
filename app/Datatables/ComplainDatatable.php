<?php

namespace App\Datatables;

use App\Models\Complain;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class ComplainDatatable extends BaseDatatable
{
    protected ?string $actionable = 'edit|delete';

    public function query(): Builder
    {
        
        return Complain::whereIn('status',['noSolved','processing'])->with(['user'])->when(request('search')['value'], function ($q) {
            $q->where('message','LIKE' , '%'.request('search')['value'].'%');
        })->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'message' => function ($model) {
                $title = $model->message;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'status' => function ($model) {
                $title = __('dashboard.'.$model->status);
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'created_at' => function ($model) {
                $title = Carbon::parse($model->created_at)->format('Y-m-d');
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'updated_at' => function ($model) {
                $title = Carbon::parse($model->updated_at)->format('Y-m-d');
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'name' => function ($model) {
                $title = $model->user?->full_name ?? $model->user?->first_name.' '.$model->user?->last_name ?? '--';
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'phone' => function ($model) {
                $title = $model->user?->phone ?? '--';
                return view('components.datatable.includes.columns.title', compact('title'));
            },
        ];
    }


    protected function getColumns(): array
    {
        return [
            Column::computed('message')->title(__('dashboard.content'))->className('text-center'),
            Column::computed('status')->title(__('dashboard.status'))->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),
            Column::computed('updated_at')->title(__('dashboard.updated_at'))->className('text-center'),
            Column::computed('name')->title(__('dashboard.name'))->className('text-center'),
            Column::computed('phone')->title(__('dashboard.phone'))->className('text-center'),
        ];
    }
}