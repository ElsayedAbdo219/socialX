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
  private static string $all = "all";

  public function index()
  {
    return $this->datatable::create($this->route)
      ->render($this->viewPath);
  }


  public function getArabCountries()
  {
    $arabicCountries = [
      "Algeria",
      "Bahrain",
      "Comoros",
      "Djibouti",
      "Egypt",
      "Iraq",
      "Jordan",
      "Kuwait",
      "Lebanon",
      "Libya",
      "Mauritania",
      "Morocco",
      "Oman",
      "Palestine",
      "Qatar",
      "Saudi Arabia",
      "Somalia",
      "Sudan",
      "Syria",
      "Tunisia",
      "United Arab Emirates",
      "Yemen"
    ];
    return $arabicCountries;
  }


  public function create()
  {
    $arabicCountries = $this->getArabCountries();
    return view('dashboard.news.add', compact('arabicCountries'));
  }

  public function store(Request $request)
  {
    $arabicCountries = implode(',', $this->getArabCountries());
    $data = $request->validate(
      [
        'title' => 'required|string',
        'title_en' => 'nullable|string',
        'contentNews_en' => 'nullable|string',
        'contentNews' => 'required|string',
        'is_poll' => 'nullable|boolean',
        'ip' => 'nullable|numeric',
        'countries' => 'nullable|array',
        'countries.*' => 'string|distinct|in:' . $arabicCountries,
      ]
    );
    if ($request->countries_status == self::$all) {
      $data['countries'] = $this->getArabCountries();
    }
    News::create($data);
    return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.created_news'));
  }

  public function edit(News $News)
  {
    $arabicCountries = $this->getArabCountries();
    return view(
      'dashboard.news.edit',
      [
        'News' => $News,
        'arabicCountries' => $arabicCountries
      ]

    );
  }


  public function update(Request $request, $News)
  {
    $arabicCountries = implode(',', $this->getArabCountries());
    $data = $request->validate(
      [
        'title' => 'nullable|string',
        'title_en' => 'nullable|string',
        'contentNews_en' => 'nullable|string',
        'contentNews' => 'nullable|string',
        'is_poll' => 'nullable|boolean',
        'ip' => 'nullable|numeric',
        'countries' => 'nullable|array',
        'countries.*' => 'string|distinct|in:' . $arabicCountries,
      ]
    );
    if ($request->countries_status == self::$all) {
      $data['countries'] = $this->getArabCountries();
    }
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
