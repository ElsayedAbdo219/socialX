<?php

namespace App\Datatables;

use App\Models\FrequentlyQuestionedAnswer;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;
use App\Models\CommonQuestion;
class FrequentlyQuestionedAnswerDatatable extends BaseDatatable
{
    protected ?string $actionable = 'show|edit|delete';

    public function query(): Builder
    {
        return CommonQuestion::orderBy('order')->when(request('search')['value'],function ($q){
            $q->where('question','LIKE','%'.request('search')['value'].'%');
        })->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'order' => function ($model) {
                $title = $model->order;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            // 'question_en' => function ($model) {
            //     $title = $model->question_en;
            //     return view('components.datatable.includes.columns.title', compact('title'));
            // },
            // 'answer_en' => function ($model) {
            //     $title = $model->answer_en;
            //     return view('components.datatable.includes.columns.title', compact('title'));
            // },
            'question' => function ($model) {
                $title = $model->question;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'answer' => function ($model) {
                $title = $model->answer;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
        ];
    }

    protected function getColumns(): array
    {
        return [
            Column::computed('order')->title(__('dashboard.order'))->className('text-center'),
            // Column::computed('question_en')->title(__('dashboard.question_en'))->className('text-center'),
            // Column::computed('answer_en')->title(__('dashboard.answer_en'))->className('text-center'),
            Column::computed('question')->title(__('dashboard.question_ar'))->className('text-center'),
            Column::computed('answer')->title(__('dashboard.answer_ar'))->className('text-center'),
        ];
    }
}