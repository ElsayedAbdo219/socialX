<?php

namespace App\Datatables;

use App\Models\Category;
use Yajra\DataTables\Html\Column;
use App\Models\MerchantCodingRequest;
use App\Enum\RegisterationRequestEnum;
use App\Support\Datatables\CustomFilters;
use Illuminate\Database\Eloquent\Builder;

class CategoryDatatable extends BaseDatatable
{
    protected ?string $actionable = 'index|edit|delete';
    
    public function query(): Builder
    {
        return Category::query()->when(request('search')['value'],function ($q){
            $q->OfName(request('search')['value']);
        })->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'name' => function ($model) {
                $title = $model?->name;
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
            Column::computed('name')->title('العنوان')->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),

        ];
    }


}
