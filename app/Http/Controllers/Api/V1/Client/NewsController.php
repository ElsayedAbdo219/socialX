<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
  public function index(Request $request)
  {
    $paginateSize = $request->query('paginateSize', 10);
    return response()->json(News::with('poll')->orderBy('id', 'desc')->paginate($paginateSize));
  }

}