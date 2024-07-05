<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
class NewsController extends Controller
{
    public function index()
    {
        return News::paginate(10) ;
    }
}
