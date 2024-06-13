<?php

namespace App\Datatables;

use App\Models\FrequentlyQuestionedAnswer;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;
use App\Models\Post;
class AdvertiseDatatable extends BaseDatatable
{
    protected ?string $actionable = 'index';

    public function query(): Builder
    {
        return Post::query()->where('status','advertisement')->when(request('search')['value'],function ($q){
            $q->ofName(request('search')['value']);
        })->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'company_id' => function ($model) {
                $title = $model->Company?->full_name ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'content' => function ($model) {
                $title = $model?->content ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'file_name' => function ($model) {
                $image = asset('/storage/companies/'.$model->file_name);
                return view('components.datatable.includes.columns.image', compact('image'));
            },
             'period' => function ($model) {
                $title = $model?->period ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
             'is_published' => function ($model) {
                $title = $model?->is_published ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
           'is_Active' => function ($model) {
                $active = $model?->is_Active;  
            return view('components.datatable.includes.columns.active', compact('active'));
           },
        ];
    }

    protected function getColumns(): array
    {
        return [
            Column::computed('company_id')->title(__('dashboard.company'))->className('text-center'),
            Column::computed('content')->title(__('dashboard.content'))->className('text-center'),
            Column::computed('file_name')->title(__('dashboard.file_name'))->className('text-center'),
            Column::computed('period')->title(__('dashboard.period'))->className('text-center'),
            Column::computed('is_published')->title(__('dashboard.is_published'))->className('text-center'),
            Column::computed('is_Active')->title(__('dashboard.is_Active'))->className('text-center'),
        ];
    }
}