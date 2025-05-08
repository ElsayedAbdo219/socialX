<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Datatables\CategoryDatatable;

class CategoryController extends Controller
{
    protected string $datatable = CategoryDatatable::class;
    protected string $route = 'admin.categories';
    protected string $viewPath = 'dashboard.Categories.list';

    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }

    public function create()
    {
        return view('dashboard.Categories.add');
    }

    public function store(Request $request)
    { 
        $data = $request->validate(['name' => 'required|string','max:255']);
        Category::create($data);
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.created_Category'));
    }

    public function edit(Category $Category)
    {
        return view('dashboard.Categories.edit',
            [
                'category' => $Category,
            ]

        );
    }


    public function update(Request $request, $Category)
    {
        $data = $request->validate(['name' => 'required|string|max:255']);
        $Category = Category::findOrfail($Category);
        $Category->update($data);
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.updated_Category'));

    }


    public function delete($Category)
    {
        Category::whereId($Category)->delete();
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.deleted_Category'));

    }


}
