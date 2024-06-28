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
    // dd($request);

    abort_if(auth("api")->user()->type === UserTypeEnum::EMPLOYEE, 403, __('ليس لديك صلاحيات لتنفيذ هذه العملية'));



    if ($type == "advertise") {

      $data = $request->validate([
        'content' => 'nullable|string',
        'file_name' => 'nullable|file|mimes:jpeg,png,mp4,avi,mov',
        'period' => 'required|string',
        'is_published' => 'required|string',
      ]);



      $fileName = uniqid() . '_' . $data['file_name']->getClientOriginalName();

      Storage::put('public/posts/' . $fileName, file_get_contents($request->file("file_name")));
      /* return $fileName; */
      $post = Post::create([
        'content' => $data['content'],
        'file_name' =>  $fileName,
        'period' => $data['period'],
        'is_published' => $data['is_published'],
        'status' => 'advertisement',
        'company_id' => auth('api')->user()->id,
      ]);




      # sending a notification to the user   
      $notifabels = User::first();
      $notificationData = [
        'title' => " اضافة اعلان جديدة ",
        'body' => "تم اضافة اعلان جديد من شركة " . auth("api")->user()->full_name,
      ];

      \Illuminate\Support\Facades\Notification::send(
        $notifabels,
        new ClientNotification($notificationData, ['database', 'firebase'])
      );





      return response()->json(['message' => 'تم الاضافة بنجاح . انتظر 24 ساعة بعد تفعيل الاعلان'], 200);
    } else {
      $data = $request->validate([
        'content' => 'required|string',
        'file_name' => 'nullable|file|mimes:jpeg,png,mp4,avi,mov',
      ]);

      $post = Post::create([
        'content' => $data['content'],
        'company_id' => auth('api')->user()->id,
        'status' => null, // Assuming 'status' can be null in your database schema
      ]);

      if ($request->hasFile('file_name')) {

        $file = $request->file('file_name');
        $fileName = uniqid() . '_' . $file->getClientOriginalName();

        Storage::put('public/posts/' . $fileName, file_get_contents($request->file("file_name")));

        $post->update([
          'file_name' => $fileName, // Corrected 'updated' to 'update'
        ]);
      }

      // The following code for sending notification should be outside of the else block
      // because it should run regardless of whether the post was created or not.
      $notifiable = User::first(); // Example: You should fetch the correct user(s) to notify
      $notificationData = [
        'title' => 'اضافة منشور جديدة',
        'body' => 'تم اضافة منشور جديد من شركة ' . auth('api')->user()->full_name,
      ];

      \Illuminate\Support\Facades\Notification::send(
        $notifiable,
        new ClientNotification($notificationData, ['database', 'firebase'])
      );


      // Return success response
      return response()->json(['message' => 'تم الاضافة بنجاح'], 200);
    }
  }


  public function getPosts()
{
  $array = ['advertisement'];
  $posts = Post::with(['company', 'review'])
              ->whereNotIn('status', $array)
              ->orderByDesc('id')
              ->paginate(10);
  
  return $posts ?? [];
  
}



  public function getAdvertises()
  {
    $posts = Post::with(['company', 'review'])
      ->where('status', '=', 'advertisement')
      ->where('is_Active', 1)->orderByDesc('id')->paginate(10);

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

    return Member::query()->when($request->filled('keyword'), function ($query) use ($request) {

      $query->where('full_name', 'like', '%' . $request->keyword . '%');
    })->where('type', 'company')->get() ?? [];
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
