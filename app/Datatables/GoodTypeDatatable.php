<?php

namespace App\Datatables;

use App\Enum\UserTypeEnum;
use App\Models\GoodType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class GoodTypeDatatable extends BaseDatatable  {

    // protected ?string $actionable = 'edit';

    public function query(): Builder
    {
        return GoodType::query(
        )->when(request('search')['value'], function ($q) {
            $q->ofName(request('search')['value']);
        })->latest();
    }
    


 protected function getCustomColumns(): array
    {
        return [
            'name' => function ($model) {
                $title = $model->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            
        ];
    }

    protected function getColumns(): array
    {
        return [
            Column::computed('name')->title(__('dashboard.name'))->className('text-center'),
           
        ];
    }


}





?>