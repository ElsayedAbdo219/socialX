<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\{AdsPrice};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use App\Datatables\AdsPriceDatatable;

class AdsPriceController extends Controller
{
  use ApiResponseDashboard;

  protected string $datatable = AdsPriceDatatable::class;
  protected string $route = 'admin.Ads-price';
  protected string $viewPath = 'dashboard.adsprice.list';

  public function index()
  {
    return $this->datatable::create($this->route)
      ->render($this->viewPath);
  }

  public function create()
  {
    return view('dashboard.adsprice.add');
  }

  public function store(Request $request)
  {
    $data = $request->validate(['price' => 'required|string|max:255', 'currency' => 'required|string|max:255']);
    AdsPrice::create($data);
    return redirect()->route('admin.Ads-price.index')->with(['success', __('dashboard.item added successfully')]);
  }

  public function edit(AdsPrice $AdsPrice)
  { 
    $currencies = [
      "EGP",
      "SAR",
      "AED",
      "KWD",
      "QAR",
      "BHD",
      "OMR",
      "JOD",
      "IQD",
      "LYD",
      "DZD",
      "MAD",
      "TND",
      "SYP",
      "SDG",
      "YER",
      "MRU",
      "DJF",
      "SOS",
      "PSE",
    ];
    // return $AdsPrice;
    return view(
      'dashboard.adsprice.edit',
      [
        'AdsPrice' => $AdsPrice,
        'currencies' => $currencies
      ]

    );
  }


  public function update(Request $request, $AdsPrice)
  {
    // dd($request->all());
    $data = $request->validate(['price' => 'required|string|max:255', 'currency' => 'required|string|max:255']);
    $AdsPrice = AdsPrice::findOrfail($AdsPrice);
    $AdsPrice->update($data);
    return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.updated_AdsPrice'));
  }


  public function destroy(AdsPrice $AdsPrice)
  {
    // dd($AdsPrice);
    $AdsPrice->delete();
    if (request()->expectsJson()) {
      return self::apiCode(200)->apiResponse();
    }
    return redirect()->route('admin.Ads-price.index')->with('success', __('dashboard.item deleted successfully'));
  }
}
