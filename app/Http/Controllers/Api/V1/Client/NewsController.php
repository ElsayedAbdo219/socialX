<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\News;
use Illuminate\Http\Request;
use GeoIP;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
  public function index(Request $request)
  {
    $paginateSize = $request->query('paginateSize', 10);
    $location = GeoIP::getLocation(request()->ip())->country;
    $newsLocation = [];
    $newsWithoutLocation = [];
    foreach (News::all() as $news) {
      if ($news->countries == "all") {
        $newsWithoutLocation [] = News::with('poll')
          ->orderBy('id', 'desc')
          ->where('countries', 'all')
          ->paginate($paginateSize);
      } else {
        $newsLocation [] = News::with('poll')
          ->whereJsonContains('countries', $location)
          ->orderBy('id', 'desc')
          ->paginate($paginateSize);
      }
    }
    $newsTotal = array_merge($newsLocation, $newsWithoutLocation);

    return response()->json($newsTotal);
  }
}
