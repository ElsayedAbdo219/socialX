<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Post;
use App\Models\User;
use App\Models\Member;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;

class PostController extends Controller
{
  protected $postResource = PostResource::class;

  public function addPost(Request $request, $type)
  {


    abort_if(auth("api")->user()->type === UserTypeEnum::EMPLOYEE, 403, __('ليس لديك صلاحيات لتنفيذ هذه العملية'));


    if ($type == "advertise") {

      $data = $request->validate([
        'content' => 'nullable|string',
        'file_name' => 'required|file',
      ]);

      $post = Post::create([
        'content' => $data['content'],
        'company_id' => auth('api')->user()->id,
      ]);

      $fileName = uniqid() . '_' . $data['file_name']->getClientOriginalName();

      Storage::disk("local")->put($fileName, file_get_contents($data['file_name']));


      $post->update(
        [

          'file_name' => $fileName,

        ]
      );

      return response()->json(['message' => 'تم الاضافة بنجاح . انتظر 24 ساعة بعد تفعيل الاعلان'], 200);
    } else {

      $data = $request->validate([
        'content' => 'required|string',
      ]);

      $post = Post::create([
        'content' => $data['content'] ,
        'company_id' => auth('api')->user()->id,
      ]);

      return response()->json(['message' => 'تم الاضافة بنجاح '], 200);

    }



    # sending a notification to the user   
    $notifabels = User::first();
    $notificationData = [
      'title' => " اضافة منشور جديدة ",
      'body' => "تم اضافة منشور جديد من شركة " . auth("api")->user()->full_name,
    ];

    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );

 
  }


  public function getPosts()
  {
    $posts = Post::with(['company', 'review'])
      ->whereHas('company', function ($q) {
        $q->where('is_Active', 1);
      })
      ->paginate(10);

    return $posts ?? [];
  }






  public function getPost(Post $post)
  {

    $post = Post::whereId($post?->id)->first();
    $postWithRelations = $post->with(['Company', 'Review'])->first();
    if (!$post) {
      abort(404);
    }
    return $postWithRelations;
    //   return $this->postResource::make($postWithRelations) ?? [];

  }


  public function searchPost(Request $request)
  {

    return Post::query()->when($request->filled('keyword'), function ($query) use ($request) {

      $query->where('content', 'like', '%' . $request->keyword . '%')

        ->orwhereHas('company', function ($q) use ($request) {

          $q->where('name', 'like', '%' . $request->keyword . '%');
        });
    })->get() ?? [];
  }


  public function getComments(Post $post)
  {

    $post = Post::whereId($post->id)->first();


    $postWithRelations = $post->with(['review'])->first();

    if (!$post) {

      abort(404);
    }

    return  $postWithRelations;
  }
}
