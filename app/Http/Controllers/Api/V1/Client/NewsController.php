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
    return response()->json(News::orderBy('id', 'desc')->paginate($paginateSize));
  }
  public function yes($id)
  {
    News::find($id)?->updateOrCreate(

      [
        'user_id' => auth('api')->user()->id
      ],
      [
        'yes' => 1
      ]
    );
    return response()->json(['message' => 'تم اضافة استطلاعك بنجاح']);
  }

  public function no($id)
  {

    News::find($id)?->updateOrCreate(
      [
        'user_id' => auth('api')->user()->id
      ],
      [
        'no' => 1
      ]
    );

    return response()->json(['message' => 'تم اضافة استطلاعك بنجاح']);
  }
}
