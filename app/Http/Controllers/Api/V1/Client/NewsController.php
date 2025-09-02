<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\News;
use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
  public function index(Request $request)
  {
    $location = GeoIP::getLocation(); 
    return $location;
    $paginateSize = $request->query('paginateSize', 10);
    return response()->json(News::with('poll')->orderBy('id', 'desc')->paginate($paginateSize));
  }

}