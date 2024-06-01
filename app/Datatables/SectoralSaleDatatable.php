<?php

namespace App\Datatables;

use App\Enum\UserTypeEnum;
use App\Models\SectoralSelling;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class SectoralSaleDatatable extends BaseDatatable
{

    public function query(): Builder
    {
        return SectoralSelling::query()->with(['user', 'trader'])->when(request('search')['value'], function ($q) {
            $q->ofName(request('search')['value']);
        })->latest();
    }



    protected function getCustomColumns(): array
    {
        return [
            'user' => function ($model) {
                $title = $model->user?->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'trader' => function ($model) {
                $title = $model->trader?->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'phone' => function ($model) {
                $title = $model->trader?->phone;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'good_type' => function ($model) {
                $title = $model->goodType->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'payment_amout' => function ($model) {
                $title = $model->payment_amout;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'unit' => function ($model) {
                $title = $model->unit;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'quantity' => function ($model) {
                $title = $model->quantity;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'payment_type' => function ($model) {
                $title = $model->payment_type;
                return view('components.datatable.includes.columns.title', compact('title'));
            },


            'total' => function ($model) {
                $title = $model->total.' '.__('dashboard.pound');
                return view('components.datatable.includes.columns.title', compact('title'));
            },

        ];
    }

    protected function getColumns(): array
    {
        return [
            Column::computed('user')->title(__('dashboard.name'))->className('text-center'),
            Column::computed('trader')->title(__('dashboard.trader'))->className('text-center'),
            Column::computed('phone')->title(__('dashboard.phone'))->className('text-center'),
            Column::computed('good_type')->title(__('dashboard.good_type'))->className('text-center'),
            Column::computed('payment_amout')->title(__('dashboard.payment_amout'))->className('text-center'),
            Column::computed('unit')->title(__('dashboard.unit'))->className('text-center'),
            Column::computed('quantity')->title(__('dashboard.quantity'))->className('text-center'),
            Column::computed('unit_price')->title(__('dashboard.unit_price'))->className('text-center'),
            Column::computed('total')->title(__('dashboard.total'))->className('text-center'),
        ];
    }
}
