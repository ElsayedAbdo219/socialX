<?php

namespace App\Datatables;

use App\Models\Job;
use App\Enum\UserTypeEnum;
use Yajra\DataTables\Html\Column;
use App\Models\MerchantCodingRequest;
use App\Enum\RegisterationRequestEnum;
use App\Support\Datatables\CustomFilters;
use Illuminate\Database\Eloquent\Builder;

class JobDatatable extends BaseDatatable
{
    protected ?string $actionable = 'index|delete';
    
    public function query(): Builder
    {
        return Job::query()->when(request('search')['value'],function ($q){
            $q->ofName(request('search')['value']);
        })->with('member')->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'member' => function ($model) {
                $title = $model?->member?->full_name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'job_name' => function ($model) {
                $title = $model?->job_name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'employee_type' => function ($model) {
                $title = $model?->employee_type;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'job_period' => function ($model) {
                $title = $model?->job_period;
                return view('components.datatable.includes.columns.title', compact('title'));
            },


            'overview' => function ($model) {
                $title = $model?->overview;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'job_category' => function ($model) {
                $title = $model?->job_category;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

            'job_description' => function ($model) {
                $description = $model?->job_description;
                return view('components.datatable.includes.columns.array', compact('description'));
            },

              'salary' => function ($model) {
                $title = $model?->salary;
                return view('components.datatable.includes.columns.title', compact('title'));
            },



              'salary_period' => function ($model) {
                $title = $model?->salary_period;
                return view('components.datatable.includes.columns.title', compact('title'));
            },


              'experience' => function ($model) {
                $title = $model?->experience;
                return view('components.datatable.includes.columns.title', compact('title'));
            },

              'is_Active' => function ($model) {
                $active = $model?->is_Active;
                return view('components.datatable.includes.columns.active', compact('active'));
            },

            
            'work_level' => function ($model) {
                $title = $model?->work_level;  
                return view('components.datatable.includes.columns.title', compact('title'));

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
             Column::computed('member')->title(__('dashboard.company'))->className('text-center'),
            Column::computed('job_name')->title(__('dashboard.job_name'))->className('text-center'),
            Column::computed('employee_type')->title(__('dashboard.employee_type'))->className('text-center'),
            Column::computed('job_period')->title(__('dashboard.job_period'))->className('text-center'),
            Column::computed('overview')->title(__('dashboard.overview'))->className('text-center'),
            Column::computed('job_category')->title(__('dashboard.job_category'))->className('text-center'),
             Column::computed('job_description')->title(__('dashboard.job_description'))->className('text-center'),
            Column::computed('salary')->title(__('dashboard.salary'))->className('text-center'),
            Column::computed('salary_period')->title(__('dashboard.salary_period'))->className('text-center'),
            Column::computed('experience')->title(__('dashboard.experience'))->className('text-center'),
            Column::computed('is_Active')->title(__('dashboard.status'))->className('text-center'),
            Column::computed('work_level')->title(__('dashboard.work_level'))->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),

        ];
    }


}
