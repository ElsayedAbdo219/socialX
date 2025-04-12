<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Post;
use App\Models\SharedPost;
use App\Models\User;
use App\Models\Member;
use App\Models\Intro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;
use App\Enum\PostTypeEnum;
use Illuminate\Http\JsonResponse;
use App\Services\PostService;
use App\Http\Requests\Api\V1\Client\PostRequest;
class PostController extends Controller {
  
  protected $postResource = PostResource::class;
  protected $postservice;
  private $Relations = ['user', 'comments','comments.commentsPeplied','comments.ReactsTheComment', 'reacts'];

  public function __construct(PostService $postservice)
  {
    $this->postservice = $postservice;
  }

  public function all(): mixed
  {
          // البوستات الأصلية
      $ownPosts = Post::with($this->Relations)
          ->where('is_Active', 1)
          ->get()
          ->map(function ($post) {
              $post->type = 'original';
              return $post;
          });
  
      // البوستات المشتركة (بنستخدم post()->with()->first())
      $sharedPosts = SharedPost::with('userShared')->get()->map(function ($sharedPost) {
          $shared = $sharedPost->post()->with($this->Relations)->first();
          if ($shared) {
              $shared->type = 'shared';
              $shared->sharedPerson = $sharedPost->userShared;
              return $shared;
          }
      })->filter();
  
      // دمج الكولكشنز
      $allPosts = collect([$ownPosts, $sharedPosts])
          ->collapse()
          ->sortByDesc('created_at')
          ->values();
  
      return $allPosts->customPaginate(5);
  }
  
  

  public function add(PostRequest $request)
  {
      if ($request['type'] == PostTypeEnum::ADVERTISE) {
      return $this->postservice->addPostAdertise($request);
      }else{
        return $this->postservice->addPostNormal($request);
      }
  }

  public function show($Post_Id) :mixed
   {
   return Post::whereId($Post_Id)->first();
   }

   public function update(PostRequest $request,$Post_Id)
   {
    // dd($request);
     if ($request['type'] == PostTypeEnum::ADVERTISE) {
      return $this->postservice->updatePostAdertise($request,$Post_Id);
     }else{
      return $this->postservice->updatePostNormal($request,$Post_Id);
      }
   }

   public function get($User_Id)
   {
    $User = Member::find($User_Id);

    $Relations = ['user', 'comments','comments.commentsPeplied','comments.ReactsTheComment', 'reacts'];
          // البوستات الأصلية
      $ownPosts = $User?->posts()?->with($this->Relations)
          ->where('is_Active', 1)
          ->get()
          ->map(function ($post) {
              $post->type = 'original';
              return $post;
          });
  
      // البوستات المشتركة (بنستخدم post()->with()->first())
      $sharedPosts = $User?->shares()->get()->map(function ($sharedPost) {
          $shared = $sharedPost->post()->with($this->Relations)->first();
          if ($shared) {
              $shared->type = 'shared';
              $shared->sharedPerson = $sharedPost->userShared;
              return $shared;
          }
      })->filter();
  
      // دمج الكولكشنز
      $allPosts = collect([$ownPosts, $sharedPosts])
          ->collapse()
          ->sortByDesc('created_at')
          ->values();
  
      return $allPosts->customPaginate(5);

   }

  public function delete($Post_Id) :mixed
   {
   Post::whereId($Post_Id)->delete();
   return response()->json(['message' => 'تم حذف المنشور بنجاح'], 200);
   }



























































  

   public function addPostIntro(Request $request)
   {
      $dataValidatedChecked = $request->validate([
        'file_name' => 'required|file|mimes:jpeg,png,mp4,avi,mov,jfif',
    ]);
    $fileName = basename(Storage::disk('public')->put('posts', file_get_contents($dataValidatedChecked['file_name'])));
    $post = Intro::updateOrCreate([ 'company_id' => auth('api')->user()->id, ],['file_name' => $fileName]);
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

  public function getPostIntro()
  {
    return  Intro::where('company_id',auth('api')->user()->id)
    ->first();
  }

  //  
}

?>