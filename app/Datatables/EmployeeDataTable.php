<?php

namespace App\Datatables;

use App\Models\Member;
use App\Models\Employee;
use App\Enum\UserTypeEnum;
use Yajra\DataTables\Html\Column;
use App\Models\MerchantCodingRequest;
use App\Enum\RegisterationRequestEnum;
use App\Support\Datatables\CustomFilters;
use Illuminate\Database\Eloquent\Builder;

class EmployeeDataTable extends BaseDatatable
{
  protected ?string $actionable = 'index|edit|delete';

  public function query(): Builder
  {
    return Member::query()->where('type', UserTypeEnum::EMPLOYEE)->when(request('search')['value'], function ($q) {
      $q->ofName(request('search')['value']);
    })->latest();
  }

  protected function getCustomColumns(): array
  {
    return [
      'name' => function ($model) {
        $title = $model?->first_name . ' ' . $model?->last_name;
        return view('components.datatable.includes.columns.title', compact('title'));
      },

      'personal_photo' => function ($model) {
        // return $model->personal_photo ;
        if (is_null($model->personal_photo)) {
          return __('<span class="text-danger">' . __("dashboard.No_Personal_Photo") . '</span>');
        }
        $image = asset($model->personal_photo);
        return view('components.datatable.includes.columns.image', compact('image'));
      },

      'coverletter' => function ($model) {
        if (is_null($model->coverletter)) {
          return __('<span class="text-danger">' . __("dashboard.No_Cover_Letter") . '</span>');
        }
        $image = asset($model->coverletter);
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
      'verfication_account' => function ($model) {
        $selected = $model->verfication_account;
        return view('components.datatable.includes.columns.radio-button', [
          'name' => 'verfication_account_' . $model->id,
          'options' => [
            1 => __('dashboard.yes'),
            0 =>  __('dashboard.no')
          ],
          'selected' => $selected,
          'userId' => $model->id
        ]);
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
      Column::computed('personal_photo')->title(__('dashboard.image'))->className('text-center'),
      Column::computed('coverletter')->title(__('dashboard.coverletter'))->className('text-center'),
      Column::computed('email')->title(__('dashboard.email'))->className('text-center'),
      Column::computed('address')->title(__('dashboard.address'))->className('text-center'),
      Column::computed('website')->title(__('dashboard.website'))->className('text-center'),
      Column::computed('verfication_account')->title(__('dashboard.verfication_account'))->className('text-center'),
      Column::computed('is_Active')->title(__('dashboard.status'))->className('text-center'),
      Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),

    ];
  }
}
