<?php

namespace App\Datatables;

use App\Models\Member;
use App\Enum\UserTypeEnum;
use App\Models\Sponser;
use Yajra\DataTables\Html\Column;
use Illuminate\Database\Eloquent\Builder;

class SponserDatatable extends BaseDatatable
{
    protected ?string $actionable = 'index|delete';
    
    public function query(): Builder
    {
        return Sponser::query()->orderBy('order', 'asc')->when(request('search')['value'],function ($q){
            $q->ofName(request('search')['value']);
        })->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'user_id' => function ($model) {
                $title = $model?->company->full_name ?? '';
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'image' => function ($model) {
                $image = asset($model->image);
                return view('components.datatable.includes.columns.image', compact('image'));
            },

            'days_number' => function ($model) {
                $title = $model?->days_number;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'price' => function ($model) {
                $title = $model?->price;
                return view('components.datatable.includes.columns.title', compact('title'));
            },


            'status' => function ($model) {
                $title = $model?->status;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'payment_status' => function ($model) {
                $title = $model?->payment_status;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

           
        ];
    }
    // git push  https://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@github.com/True-Solution/true-project.git
   // git config --global --unset credential mangers

    protected function getColumns(): array
    {
        return [
            Column::computed('user_id')->title(__('dashboard.name'))->className('text-center'),
            Column::computed('image')->title(__('dashboard.image'))->className('text-center'),
            Column::computed('days_number')->title(__('dashboard.days_number'))->className('text-center'),
            Column::computed('price')->title(__('dashboard.price'))->className('text-center'),
            Column::computed('status')->title(__('dashboard.status'))->className('text-center'),
            Column::computed('payment_status')->title(__('dashboard.payment_status'))->className('text-center'),

        ];
    }


}
