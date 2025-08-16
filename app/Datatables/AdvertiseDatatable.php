<?php

namespace App\Datatables;

use App\Models\FrequentlyQuestionedAnswer;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;
use App\Models\Post;
use Carbon\Carbon;

class AdvertiseDatatable extends BaseDatatable
{
  protected ?string $actionable = 'index|edit|delete';

  public function query(): Builder
  {
    return Post::query()->where('status', 'advertise')->when(request('search')['value'], function ($q) {
      $q->ofName(request('search')['value']);
    })->with('adsStatus')->latest();
  }

  protected function getCustomColumns(): array
  {
    return [
      'user_id' => function ($model) {
        $title = $model->user?->full_name;
        return view('components.datatable.includes.columns.title', compact('title'));
      },
      'content' => function ($model) {
        $title = $model?->content;
        return view('components.datatable.includes.columns.title', compact('title'));
      },
      'file_name' => function ($model) {
        if(!isset($model->file_name) || empty($model->file_name)) {
          return '';
        }
        $video = isset($model->file_name) ?  asset($model->file_name) : '';
        $extension = pathinfo($model->file_name, PATHINFO_EXTENSION);
        $mimeTypes = [
          'mp4' => 'video/mp4',
          'webm' => 'video/webm',
          'ogv' => 'video/ogg',
          'ogg' => 'video/ogg',
          'mov' => 'video/quicktime',
        ];

        $type = $mimeTypes[$extension] ?? 'video/mp4'; 
        return view('components.datatable.includes.columns.video', compact('video','type'));
      },
      'image' => function ($model) {
        if(!isset($model->image) || empty($model->image)) {
          return '';
        }
        $image = isset($model->image) ?  asset($model->image) : '';
        return view('components.datatable.includes.columns.image', compact('image'));
      },
      'period' => function ($model) {
        $title = $model?->period;
        return view('components.datatable.includes.columns.title', compact('title'));
      },
      'is_published' => function ($model) {
        $title = $model?->is_published;
        return view('components.datatable.includes.columns.title', compact('title'));
      },
      'price' => function ($model) {
        $title = $model?->price;
        return view('components.datatable.includes.columns.title', compact('title'));
      },

      'created_at' => function ($model) {
        $title = Carbon::parse($model->created_at)->format('Y-m-d');
        return view('components.datatable.includes.columns.title', compact('title'));
      },

      'active' => function ($model) {
        $active = $model?->adsStatus?->status;
        // dd($active);
        return view('components.datatable.includes.columns.active', compact('active'));
      },
      'reason_cancelled' => function ($model) {
        $title = $model?->adsStatus?->reason_cancelled ?? '';
        return view('components.datatable.includes.columns.title', compact('title'));
      },
    ];
  }

  protected function getColumns(): array
  {
    return [
      Column::computed('user_id')->title(__('dashboard.company'))->className('text-center'),
      Column::computed('content')->title(__('dashboard.content'))->className('text-center'),
      Column::computed('file_name')->title(__('dashboard.video'))->className('text-center'),
      Column::computed('image')->title(__('dashboard.image'))->className('text-center'),
      Column::computed('period')->title(__('dashboard.period'))->className('text-center'),
      Column::computed('is_published')->title(__('dashboard.is_published'))->className('text-center'),
      Column::computed('price')->title(__('dashboard.price'))->className('text-center'),
      Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),
      Column::computed('active')->title(__('dashboard.is_Active'))->className('text-center'),
      Column::computed('reason_cancelled')->title(__('dashboard.reason_cancelled'))->className('text-center'),
    ];
  }
}
