<?php

namespace App\Datatables;

use App\Models\Notification;
use App\Notifications\DashboardNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Column;

class NotificationDatatable extends BaseDatatable
{
    protected ?string $actionable = '';

    public function query(): Builder
    {

        return Notification::where('type', get_class(new DashboardNotification()))
            ->when(request('search')['value'], function ($q) {
                $q->where('data', 'like', '%' . request('search')['value'] . '%');
            })
            ->select('data->serial as serial', DB::raw('COUNT(*) as count'))
            ->selectRaw('MAX(id) as id')
            ->selectRaw('MAX(data) as data')
            ->selectRaw('MAX(created_at) as created_at')
            ->selectRaw('MAX(read_at) as read_at')
            ->groupBy('data->serial');
    }

    protected function getCustomColumns(): array
    {
        return [
            'title' => function ($model) {
                    $title = json_decode($model->data)->title ?? null;
                    return view('components.datatable.includes.columns.title', compact('title'));
            },
            'body' => function ($model) {
                    $title = json_decode($model->data)->body ?? null;
                    return view('components.datatable.includes.columns.title', compact('title'));
            }
           
        ];
}


    protected function getColumns(): array
    {

        return [
            Column::computed('title')->title(__('dashboard.title'))->className('text-center'),
            Column::computed('body')->title(__('dashboard.content'))->className('text-center'),
        ];
    }
}
