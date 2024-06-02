<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\GoodType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Datatables\GoodTypeDatatable;

class GoodTypeController extends Controller
{
    protected string $datatable = GoodTypeDatatable::class;
    protected string $route = 'admin.goods-types';
    protected string $viewPath = 'dashboard.goods.list';

    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }

    public function create()
    {
        return view('dashboard.goods.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|unique:good_types,name']);
        GoodType::create($data);
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.created_goods'));
    }

    public function edit(GoodType $goodType)
    {
        return view('dashboard.goods.edit',
            [
                'goodType' => $goodType,
            ]

        );
    }


    public function update(Request $request, $goodType)
    {
        $data = $request->validate(['name' => 'required|unique:good_types,name']);
        $goodtype = GoodType::findOrfail($goodType);
        $goodtype->update($data);
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.updated_goods'));

    }


    public function delete($goodType)
    {
        GoodType::whereId($goodType)->delete();
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.deleted_goods'));

    }


}
