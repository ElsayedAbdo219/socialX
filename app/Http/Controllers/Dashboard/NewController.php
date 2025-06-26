<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\News;

use Illuminate\Http\Request;
use App\Datatables\NewDatatable;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;

class NewController extends Controller
{
  use ApiResponseDashboard;
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
        $data = $request->validate(
          [
            'title' => 'required|string',
            'title_en' => 'nullable|string',
            'contentNews_en' => 'nullable|string',
            'contentNews' => 'required|string',
            'is_poll' => 'nullable|boolean'
          ]
        );
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
        $data = $request->validate(
          [
            'title' => 'required|string',
            'title_en' => 'nullable|string',
            'contentNews_en' => 'nullable|string',
            'contentNews' => 'required|string',
            'is_poll' => 'nullable|boolean'
          ]
        );
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
