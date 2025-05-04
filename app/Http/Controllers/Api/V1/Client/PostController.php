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
  private $Relations = ['user', 'comments.user','comments.commentsPeplied.user','comments.ReactsTheComment.user', 'reacts.user'];

  public function __construct(PostService $postservice)
  {
    $this->postservice = $postservice;
  }

  public function all(Request $request): mixed
  {
    $Paginate_Size = $request->query('Paginate_Size') ?? 10;
    
          // البوستات الأصلية
      $ownPosts = Post::with($this->Relations)
        //   ->where('is_Active', 1)
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
  
      return $allPosts->customPaginate($Paginate_Size);
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

   public function get(Request $request ,$User_Id)
   {
    $Paginate_Size = $request->query('Paginate_Size') ?? 10;
    $User = Member::find($User_Id);
     $Relations = ['user', 'comments.user','comments.commentsPeplied.user','comments.ReactsTheComment.user', 'reacts.user'];

          // البوستات الأصلية
      $ownPosts = $User?->posts()?->with($this->Relations)
        //   ->where('is_Active', 1)
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
  
      return $allPosts->customPaginate($Paginate_Size);

   }

  public function delete($Post_Id) :mixed
   {
   Post::whereId($Post_Id)->delete();
   return response()->json(['message' => 'تم حذف المنشور بنجاح'], 200);
   }
  

    public function getMyPosts(Request $request)
    {
        // return '123';
        //   dd($request->query('Paginate_Size'));
     $Paginate_Size = $request->query('Paginate_Size') ?? 10;
    // return auth('api')->user()->posts()->where('is_Active', 1)->orderByDesc('id')->paginate($Paginate_Size);  
    return auth('api')->user()->posts()->orderByDesc('id')->paginate($Paginate_Size);    

   }



   public function showSharesOfPost($Paginate_Size,$Post)
   {
    return SharedPost::where('post_id',$Post)->with('userShared')->orderByDesc('id')->paginate($Paginate_Size);
   }


   public function addPostIntro(Request $request)
   {
       $dataValidatedChecked = $request->validate([
           'file_name' => 'required|file|mimes:mp4,avi,mov,jfif',
       ]);
   
       $file = $request->file('file_name');
       $fileName = basename(Storage::disk('public')->putFile('posts', $file));
   
       $post = Intro::updateOrCreate(
           ['company_id' => auth('api')->user()->id],
           ['file_name' => $fileName]
       );
   
       // إرسال إشعار
       $notifabels = User::first(); // تأكد إن هذا المستخدم هو اللي يحتاج الإشعار
       $notificationData = [
           'title' => "إضافة فيديو تقديمي جديد",
           'body' => "تمت إضافة فيديو تقديمي جديد من شركة " . auth("api")->user()->full_name,
       ];
   
       \Illuminate\Support\Facades\Notification::send(
           $notifabels,
           new ClientNotification($notificationData, ['database', 'firebase'])
       );
   
       return response()->json(['message' => 'تمت الإضافة بنجاح'], 200);
   }
   

  public function getPostIntro($id)
  {
    return  Intro::where('id',$id)
    ->first();
  }

  //  

   public function deletePostIntro($id)
  {
    $intro = Intro::where('id',$id)
    ->first();
    Storage::delete('posts/'.$intro?->file_name);
    $intro->delete();
  
    return response()->json(['message' => 'تمت الحذف بنجاح'], 200);
  }
}

?>