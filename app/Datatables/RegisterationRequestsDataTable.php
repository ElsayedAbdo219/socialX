<?php

namespace App\Datatables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use App\Models\MerchantCodingRequest;
use App\Enum\RegisterationRequestEnum;
use App\Support\Datatables\CustomFilters;
use Illuminate\Database\Eloquent\Builder;

class RegisterationRequestsDataTable extends BaseDatatable
{
    protected ?string $actionable = 'index|edit';
    
    public function query(): Builder
    {
        return User::where('is_active',0)->when(request('search')['value'],function ($q){
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
            'mobile' => function ($model) {
                $title = $model->mobile;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'is_active' => function ($model) {
                $title = $model->is_active == RegisterationRequestEnum::ACTIVE ? __('dashboard.active') : __('dashboard.disactive');  
                return view('components.datatable.includes.columns.title', compact('title'));

            },
            'created_at' => function ($model) {
                $title = $model->created_at;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
           
        ];
    }
    // git push  https://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@github.com/True-Solution/true-project.git
   // git config --global --unset credential mangers

    protected function getColumns(): array
    {
        return [
            Column::computed('name')->title(__('dashboard.name'))->className('text-center'),
            Column::computed('mobile')->title(__('dashboard.phone'))->className('text-center'),
            Column::computed('is_active')->title(__('dashboard.status'))->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),

        ];
    }


}
