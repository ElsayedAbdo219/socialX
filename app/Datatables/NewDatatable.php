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
            'contentNews' => function ($model) {
                $title = $model?->contentNews;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
              'is_poll' => function ($model) {
                $title = $model?->is_poll == 1 ? __('dashboard.yes') : __('dashboard.no');
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
            Column::computed('title')->title(__('dashboard.title'))->className('text-center'),
            Column::computed('contentNews')->title(__('dashboard.contentNews'))->className('text-center'),
            Column::computed('is_poll')->title(__('dashboard.is_poll'))->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),

        ];
    }


}
