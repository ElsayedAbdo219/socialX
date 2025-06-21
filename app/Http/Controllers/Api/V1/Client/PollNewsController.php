<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\News;
use App\Models\PollNews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PollNewsController extends Controller
{
  public function index(Request $request,$news_id)
  {
    $paginateSize = $request->query('paginateSize', 10);
    $polls = PollNews::with(['news', 'user'])
      ->where('news_id', $news_id)
      ->orderBy('id', 'desc')
      ->paginate($paginateSize);

    return response()->json([
       'yesTotal' =>  $polls->where('yes', 1)->count(),
       'noTotal' =>  $polls->where('no', 1)->count(),
       'polls' =>  $polls
      ]
    );
  }
  public function yes($id)
  {
    $PollNews = PollNews::where('news_id',$id)->where('user_id',auth('api')->id())?->first();
    if (!$PollNews) {
      $PollNews = new PollNews();
      $PollNews->news_id = $id;
      $PollNews->user_id = auth('api')->user()->id;
    }
    $PollNews->yes = 1;
    $PollNews->no = 0;
    $PollNews->save();
    return response()->json(['message' => 'تم اضافة استطلاعك بنجاح']);
  }

  public function no($id)
  {
    $PollNews = PollNews::where('news_id',$id)->where('user_id',auth('api')->id())?->first();
    if (!$PollNews) {
      $PollNews = new PollNews();
      $PollNews->news_id = $id;
      $PollNews->user_id = auth('api')->user()->id;
    }
    $PollNews->no = 1;
    $PollNews->yes = 0;
    $PollNews->save();

    return response()->json(['message' => 'تم اضافة استطلاعك بنجاح']);
  }
}
