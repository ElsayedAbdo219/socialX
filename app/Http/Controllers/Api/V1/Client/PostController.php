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

   if ($type == "advertise") {
    $data = $request->validate([
        'content' => 'nullable|string',
        'file_name' => 'required|file|mimes:jpeg,png,mp4,avi,mov',
        'period' => 'required|string',
        'is_published' => 'required|string',
    ]);

    $file = $request->file('file_name'); // Get the uploaded file object
    $fileName = uniqid() . '_' . $file->getClientOriginalName(); // Generate a unique filename

    // Store the file in storage
   $storage = Storage::put('public/posts/' . $fileName, file_get_contents($file));
    
  

    $post = Post::create([
        'content' => $data['content'],
        'file_name' => $fileName,
        'period' => $data['period'],
        'is_published' => $data['is_published'],
        'status' => 'advertisement',
        'company_id' => auth('api')->user()->id,
    ]);

    // Any additional operations after creating the post





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
    } 
    elseif($type == "intro"){
      $data = $request->validate([
        'content' => 'nullable|string',
        'file_name' => 'required|file|mimes:jpeg,png,mp4,avi,mov',
        'period' => 'nullable|string',
        'is_published' => 'nullable|string',
    ]);

    $file = $request->file('file_name'); // Get the uploaded file object
    $fileName = uniqid() . '_' . $file->getClientOriginalName(); // Generate a unique filename

    // Store the file in storage
   $storage = Storage::put('public/posts/' . $fileName, file_get_contents($file));
    
  

    $post = Post::create([
        'content' => $data['content'],
        'file_name' => $fileName,
        'period' => $data['period'],
        'is_published' => $data['is_published'],
        'status' => 'intro',
        'company_id' => auth('api')->user()->id,
    ]);

    // Any additional operations after creating the post





      # sending a notification to the user   
      $notifabels = User::first();
      $notificationData = [
        'title' => " اضافة فيديو تقديمي جديد ",
        'body' => "تم اضافة فيديو تقديمي جديد من شركة " . auth("api")->user()->full_name,
      ];

      \Illuminate\Support\Facades\Notification::send(
        $notifabels,
        new ClientNotification($notificationData, ['database', 'firebase'])
      );





      return response()->json(['message' => 'تم الاضافة بنجاح '], 200);
    }
    else {
      $data = $request->validate([
        'content' => 'required|string',
        'file_name' => 'nullable|file|mimes:jpeg,png,mp4,avi,mov',
      ]);

      $post = Post::create([
        'content' => $data['content'],
        'company_id' => auth('api')->user()->id,
        'status' => 'normal', // Assuming 'status' can be null in your database schema
      ]);

      if ($request->hasFile('file_name')) {

       $file = $request->file('file_name'); // Get the uploaded file object
      $fileName = uniqid() . '_' . $file->getClientOriginalName(); // Generate a unique filename

    // Store the file in storage
    $storage = Storage::put('public/posts/' . $fileName, file_get_contents($file));


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

    $posts = Post::with(['company', 'review','review.member', 'likes','likes.member', 'likesSum','dislikes','dislikes.member','dislikesSum'])
      ->orderByDesc('id')
      ->where('status', '=', 'normal')
      ->paginate(10);

    return $posts ?? [];
  }

  public function getPostIntro()
  {

    $post = Post::with(['company', 'review','review.member', 'likes','likes.member', 'likesSum','dislikes','dislikes.member','dislikesSum'])
      ->orderByDesc('id')
      ->where('status', '=', 'intro')->where('company_id',auth('api')->user()->id)
      ->first();

    return $post ?? [];
  }

  public function getAdvertises()
  {
    $posts = Post::with(['company', 'review','review.member', 'likes','likes.member', 'likesSum','dislikes','dislikes.member','dislikesSum'])
      ->where('status', '=', 'advertisement')
      ->where('is_Active', 1)->orderByDesc('id')->paginate(10);

    return $posts ?? [];
  }






  public function getPost($post)
  {

    $post = Post::whereId($post)->first();
    // return $post;
    if (!$post) {
      abort(404);
    }
    return $post->load(['company', 'review','review.member', 'likes','likes.member', 'likesSum','dislikes','dislikes.member','dislikesSum']);
    //   return $this->postResource::make($postWithRelations) ?? [];

  }


  public function searchPost(Request $request)
  {

    return Member::query()->when($request->filled('keyword'), function ($query) use ($request) {

      $query->where('full_name', 'like', '%' . $request->keyword . '%');
    })->where('type', 'company')->get() ?? [];
  }


  public function getComments($post)
  {

    $post = Post::whereId($post)->first();


    /* $postWithRelations = $post->with(['review'])->first(); */

    if (!$post) {

      abort(404);
    }

    return  $post->load(['company', 'review','review.member', 'likes','likes.member', 'likesSum','dislikes','dislikes.member','dislikesSum']);
  }



  public function showMember($member)
  {
    $posts = Post::whereHas('company', function ($query) use ($member) {
      $query->where('company_id', $member);
    })->orderByDesc('id')->paginate(10);

    return $posts;
  }


  //  
}
