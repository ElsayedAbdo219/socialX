<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\{AdsPrice};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use App\Datatables\AdsPriceDatatable;
use App\Http\Requests\Dashboard\AdsPriceRequest;

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

  public function store(AdsPriceRequest $request)
  {
    $data = $request->validated();
    if ($request->type == 'image') {
      $adsPriceExists = AdsPrice::where('type', 'image')
        ->where('currency', $data['currency'])
        ->first();
      if ($adsPriceExists) {
        return redirect()->back()->withErrors(['currency' => __('dashboard.image_price_already_exists')]);
      }
    } else {
      $adsPriceExists = AdsPrice::where('type', 'video')
        ->where('currency', $data['currency'])
        ->where('resolution', $data['resolution'])
        ->first();
      if ($adsPriceExists) {
        return redirect()->back()->withErrors(['currency' => __('dashboard.video_price_already_exists')]);
      }
    }
    // dd($data);
    AdsPrice::create($data);
    return redirect()->route('admin.Ads-price.index')->with(['success', __('dashboard.item added successfully')]);
  }

  public function edit($AdsPrice)
  { 
    $AdsPrice = AdsPrice::findOrFail($AdsPrice);
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
    return view(
      'dashboard.adsprice.edit',
      [
        'AdsPrice' => $AdsPrice,
        'currencies' => $currencies
      ]

    );
  }


  public function update(AdsPriceRequest $request, $AdsPrice)
  {
    // dd($request->all());
    $data = $request->validated();
    $AdsPrice = AdsPrice::findOrfail($AdsPrice);
    if ($request->type == 'image') {
      $adsPriceExists = AdsPrice::where('type', 'image')
        ->where('currency', $data['currency'])
        ->where('id', '!=', $AdsPrice->id)
        ->first();
      if ($adsPriceExists) {
        return redirect()->back()->withErrors(['currency' => __('dashboard.image_price_already_exists')]);
      }
    } else {
      $adsPriceExists = AdsPrice::where('type', 'video')
        ->where('currency', $data['currency'])
        ->where('resolution', $data['resolution'])
        ->where('id', '!=', $AdsPrice->id)
        ->first();
      if ($adsPriceExists) {
        return redirect()->back()->withErrors(['currency' => __('dashboard.video_price_already_exists')]);
      }
    }
    $AdsPrice->update($data);
    return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.updated_AdsPrice'));
  }


  public function destroy(AdsPrice $AdsPrice)
  {
    // dd($AdsPrice->count());
    $AdsPrice->delete();
    if (request()->expectsJson()) {
      return self::apiCode(200)->apiResponse();
    }
    return redirect()->route('admin.Ads-price.index')->with('success', __('dashboard.item deleted successfully'));
  }
}
