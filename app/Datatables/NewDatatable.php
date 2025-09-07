<?php

namespace App\Datatables;

use App\Models\News;
use Yajra\DataTables\Html\Column;
use App\Models\MerchantCodingRequest;
use App\Enum\RegisterationRequestEnum;
use App\Support\Datatables\CustomFilters;
use Illuminate\Database\Eloquent\Builder;

class NewDatatable extends BaseDatatable
{
    protected ?string $actionable = 'index|edit|delete';
    
    public function query(): Builder
    {
        return News::query()->when(request('search')['value'],function ($q){
            $q->OfContent(request('search')['value']);
        })->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'title' => function ($model) {
                $title = $model?->title;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'title_en' => function ($model) {
                $title = $model?->title_en ?? '';
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'contentNews' => function ($model) {
                $title = $model?->contentNews;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'contentNews_en' => function ($model) {
                $title = $model?->contentNews_en ?? '';
                return view('components.datatable.includes.columns.title', compact('title'));
            },
              'is_poll' => function ($model) {
                $title = $model?->is_poll == 1 ? __('dashboard.yes') : __('dashboard.no');
                return view('components.datatable.includes.columns.title', compact('title'));
            },
              'countries' => function ($model) {
                $countries = is_array($model->countries) ? $model->countries : [__('dashboard.all_countries')];
                return view('components.datatable.includes.columns.array', compact('countries'));
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
            Column::computed('title')->title(__('dashboard.title_ar'))->className('text-center'),
            Column::computed('title_en')->title(__('dashboard.title_en'))->className('text-center'),
            Column::computed('contentNews')->title(__('dashboard.contentNews_ar'))->className('text-center'),
            Column::computed('contentNews_en')->title(__('dashboard.contentNews_en'))->className('text-center'),
            Column::computed('is_poll')->title(__('dashboard.is_poll'))->className('text-center'),
            Column::computed('countries')->title(__('dashboard.countries'))->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),

        ];
    }


}
