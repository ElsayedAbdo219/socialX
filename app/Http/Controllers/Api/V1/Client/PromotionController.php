<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    public function getFreePromotions(Request $request)
    {
      $paginateSize = $request->query('paginateSize', 10);
      return Promotion::with('resolutions')->paginate($paginateSize);
    }
    
}
