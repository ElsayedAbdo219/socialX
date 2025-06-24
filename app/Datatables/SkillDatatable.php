<?php

namespace App\Datatables;

use App\Models\Skill;
use Yajra\DataTables\Html\Column;
use App\Models\MerchantCodingRequest;
use App\Enum\RegisterationRequestEnum;
use App\Support\Datatables\CustomFilters;
use Illuminate\Database\Eloquent\Builder;

class SkillDatatable extends BaseDatatable
{
    protected ?string $actionable = 'index|edit|delete';
    
    public function query(): Builder
    {
        return Skill::query()->when(request('search')['value'],function ($q){
            $q->OfName(request('search')['value'])
              ->orWhereHas('category', function ($query) {
                  $query->ofName(request('search')['value']);
              });
        })->latest();
    }

    protected function getCustomColumns(): array
    {
        return [
            'name' => function ($model) {
                $title = $model?->name;
                return view('components.datatable.includes.columns.title', compact('title'));
            },
            'category' => function ($model) {
                $title = $model?->category?->name;
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
            Column::computed('name')->title(__('dashboard.name'))->className('text-center'),
            Column::computed('category')->title(__('dashboard.category'))->className('text-center'),
            Column::computed('created_at')->title(__('dashboard.created_at'))->className('text-center'),

        ];
    }


}
