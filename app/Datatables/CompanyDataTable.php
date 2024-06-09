<?php

namespace App\Datatables;

use App\Models\Member;
use App\Enum\UserTypeEnum;
use Yajra\DataTables\Html\Column;
use App\Models\MerchantCodingRequest;
use App\Enum\RegisterationRequestEnum;
use App\Support\Datatables\CustomFilters;
use Illuminate\Database\Eloquent\Builder;

class CompanyDataTable extends BaseDatatable
{
    protected ?string $actionable = 'index|edit|delete';
    
    public function query(): Builder
    {
        return Member::query()->where('type',UserTypeEnum::COMPANY)->when(request('search')['value'],function ($q){
            $q->ofName(request('search')['value']);
        })->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'name' => function ($model) {
                $title = $model?->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'logo' => function ($model) {
                $image = asset('/storage/app/companies/'.$model->logo);
                return view('components.datatable.includes.columns.image', compact('image'));
            },


            'coverletter' => function ($model) {
                $image = asset('/storage/public/companies/'.$model->coverletter);
                return view('components.datatable.includes.columns.image', compact('image'));
            },

            'email' => function ($model) {
                $title = $model?->email;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'address' => function ($model) {
                $title = $model?->address;
                return view('components.datatable.includes.columns.title', compact('title'));
            },


            'website' => function ($model) {
                $url = $model?->website;
                return view('components.datatable.includes.columns.link', compact('url'));
            },

            'email' => function ($model) {
                $title = $model?->email;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'email' => function ($model) {
                $title = $model?->email;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            
            'is_Active' => function ($model) {
                $active = $model?->is_Active;  
                return view('components.datatable.includes.columns.active', compact('active'));

            },
            'created_at' => function ($model) {
                $title = $model?->created_at;
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
            Column::computed('logo')->title(__('dashboard.logo_image'))->className('text-center'),
            Column::computed('coverletter')->title(__('dashboard.coverletter'))->className('text-center'),
            Column::computed('email')->title(__('dashboard.email'))->className('text-center'),
            Column::computed('address')->title(__('dashboard.address'))->className('text-center'),
            Column::computed('website')->title(__('dashboard.website'))->className('text-center'),
            Column::computed('is_Active')->title(__('dashboard.status'))->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),

        ];
    }


}
