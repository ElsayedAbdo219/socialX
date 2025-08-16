<?php

namespace App\Datatables;

use App\Models\FrequentlyQuestionedAnswer;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;
use App\Models\Post;
use Carbon\Carbon;
class PostDatatable extends BaseDatatable
{
    protected ?string $actionable = 'index|delete|edit';

    public function query(): Builder
    {
        return Post::query()->where('status','normal')->when(request('search')['value'],function ($q){
            $q->where('content','LIKE','%'.request('search')['value'].'%');
        })->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'company_id' => function ($model) {
                $title = $model->Company?->name ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'status' => function ($model) {
                return __('dashboard.'.$model->status) ;
                $title = __('dashboard.'.$model->status) ;
                return view('components.datatable.includes.columns.status', compact('title'));
            },

            'content' => function ($model) {
                $title = $model?->content ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            // 'file_name' => function ($model) {
            //     $image = $model->file_name ? asset('storage/posts/'.$model->file_name) : '';
            //     return view('components.datatable.includes.columns.image', compact('image'));
            // },
            // 'image' => function ($model) {
            //     $image = $model->image ?  asset($model->image) : '';
            //     return view('components.datatable.includes.columns.image', compact('image'));
            // },
            'period' => function ($model) {
                $title = $model?->period ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
             'is_published' => function ($model) {
                $title = $model?->is_published ;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

             'created_at' => function ($model) {
                $title = Carbon::parse($model->created_at)->format('Y-m-d');
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
            Column::computed('status')->title(__('dashboard.status'))->className('text-center'),
            Column::computed('content')->title(__('dashboard.content'))->className('text-center'),
            // Column::computed('file_name')->title(__('dashboard.file_name'))->className('text-center'),
            // Column::computed('image')->title(__('dashboard.image'))->className('text-center'),
            Column::computed('period')->title(__('dashboard.period'))->className('text-center'),
            Column::computed('is_published')->title(__('dashboard.is_published'))->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),
            Column::computed('is_Active')->title(__('dashboard.is_Active'))->className('text-center'),
        ];
    }
}