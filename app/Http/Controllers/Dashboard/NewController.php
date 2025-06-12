<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Datatables\NewDatatable;

class NewController extends Controller
{
    protected string $datatable = NewDatatable::class;
    protected string $route = 'admin.news';
    protected string $viewPath = 'dashboard.news.list';

    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }

    public function create()
    {
        return view('dashboard.news.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string', 'contentNews' => 'required|string']);
        News::create($data);
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.created_news'));
    }

    public function edit(News $News)
    {
        return view('dashboard.news.edit',
            [
                'News' => $News,
            ]

        );
    }


    public function update(Request $request, $News)
    {
        $data = $request->validate(['title' => 'required|string', 'contentNews' => 'required|string']);
        $News = News::findOrfail($News);
        $News->update($data);
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.updated_news'));

    }


    public function destroy(News $News)
    {
        $News->delete();
        if (request()->expectsJson()) {
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.news.index')->with('success', __('dashboard.item deleted successfully'));
    }


}
