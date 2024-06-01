<?php

namespace App\Datatables;

use Carbon\Carbon;
use App\Models\Trader;
use App\Models\GoodType;
use App\Enum\UserTypeEnum;
use App\Models\purchasing;
use App\Enum\DeliveryWayEnum;
use Yajra\DataTables\Html\Column;
use Illuminate\Database\Eloquent\Builder;

class PurchasingFromCompanyDatatable extends BaseDatatable  {

    protected ?string $actionable = 'index';

    public function query(): Builder
    {
        return purchasing::query(
        )->OfType(UserTypeEnum::COMPANY)->with(['user','trader'])->when(request('search')['value'], function ($q) {
            $q->ofName(request('search')['value']);
        })->latest();
    }
    


    protected function getCustomColumns(): array
    {
        return [
            'user' => function ($model) {
                $title = $model->user->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'trader' => function ($model) {
                $title = $model->trader?->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'phone' => function ($model) {
                $title = $model->mobile;
                return view('components.datatable.includes.columns.title', compact('title'));
            },


            'good_type' => function ($model) {
                $title = $model->goodType->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },


            'ton_quantity' => function ($model) {
                $title = $model->ton_quantity;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'ton_quantity_price' => function ($model) {
                $title = $model->ton_quantity_price;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'delivery_way' => function ($model) {
                $title = $model->delivery_way == DeliveryWayEnum::ONSITE ? __('dashboard.onsite') : __('dashboard.wassal');
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'ton_colon_price' => function ($model) {
                $title = $model->ton_colon_price.' '.__('dashboard.pound') ?? ' ';
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            // 'deposit_money' => function ($model) {
            //     $title = $model->deposit_money;
            //     return view('components.datatable.includes.columns.title', compact('title'));
            // },
           
            // 'first_amount' => function ($model) {
            //     $title = $model?->first_amount;
            //     return view('components.datatable.includes.columns.title', compact('title'));
            // },
            // 'duration' => function ($model) {
            //     $title = $model?->duration;
            //     return view('components.datatable.includes.columns.title', compact('title'));
            // },

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
            Column::computed('ton_quantity')->title(__('dashboard.ton_quantity'))->className('text-center'),
            Column::computed('ton_quantity_price')->title(__('dashboard.ton_quantity_price'))->className('text-center'),
            Column::computed('delivery_way')->title(__('dashboard.delivery_way'))->className('text-center'),
            Column::computed('ton_colon_price')->title(__('dashboard.ton_nolon_price'))->className('text-center'),
           // Column::computed('deposit_money')->title(__('dashboard.deposit_money'))->className('text-center'),
          //  Column::computed('first_amount')->title(__('dashboard.first_amount'))->className('text-center'),
           // Column::computed('duration')->title(__('dashboard.duration'))->className('text-center'),
            Column::computed('total')->title(__('dashboard.total'))->className('text-center'),
           
        ];
    }

}





?>