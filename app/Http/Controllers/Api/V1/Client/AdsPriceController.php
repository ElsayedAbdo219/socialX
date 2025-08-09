<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\AdsPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdsPriceController extends Controller
{
    public function index(Request $request)
    {
        return AdsPrice::all();
    }
}
