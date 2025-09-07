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

    $news = News::with('poll')
        ->where(function ($query) use ($location) {
            $query->where('countries', 'all')
                  ->orWhereJsonContains('countries', $location);
        })
        ->orderBy('created_at', 'desc')
        ->paginate($paginateSize);

    return response()->json($news);
}
}