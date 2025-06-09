<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Post;
use App\Models\User;
use App\Models\Intro;
use App\Models\Follow;
use App\Models\Member;
use App\Enum\PostTypeEnum;
use App\Models\SharedPost;
use App\Enum\AdsStatusEnum;
use Illuminate\Http\Request;
use App\Services\PostService;
use FFMpeg\Format\Video\X264;
use App\Jobs\UploadIntroVideoJob;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;
use Illuminate\Support\Facades\Notification;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use App\Http\Requests\Api\V1\Client\PostRequest;

class PostController extends Controller
{

  protected $postResource = PostResource::class;
  protected $postservice;
  private $Relations = ['user', 'views', 'comments.user', 'comments.commentsPeplied.user', 'comments.ReactsTheComment.user', 'reacts.user'];

  public function __construct(PostService $postservice)
  {
    $this->postservice = $postservice;
  }
  // Call to undefined method Illuminate\\Database\\Eloquent\\Builder::makeHidden()
  public function all(Request $request): mixed
  {
    $Paginate_Size = $request->query('paginateSize') ?? 10;
    $posts = Post::where('status', PostTypeEnum::NORMAL)
      ->orWhere(function ($query) {
        $query->where('status', PostTypeEnum::ADVERTISE)
          ->whereHas('adsStatus', function ($q) {
            $q->where('status', AdsStatusEnum::APPROVED);
          });
      });
    $ownPosts = $posts->with($this->Relations)
      ->orderByDesc('id')
      //   ->where('is_Active', 1)
      ->get()
      ->map(function ($post) {
        if ($post->status === PostTypeEnum::NORMAL) {
          $post->makeHidden([
            'resolution',
            'start_time',
            'end_time',
            'start_date',
            'end_date',
            'period',
            'adsStatus',
            'views'
          ]);
        } elseif ($post->status === PostTypeEnum::ADVERTISE) {
          $post->views_count = $post->views()->count();
          $post->makeHidden([
            'views'
          ]);
        }
        $post->type = 'original';
        $post->user->is_following = Follow::where('followed_id', $post?->user->id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        $post->my_react = $post->reacts()->where('user_id', auth('api')->id())?->first() ?? null;
        $post->reacts = $post->reacts->map(function ($react) {
          $react->user->is_following = Follow::where('followed_id', $react->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        });
        $post->comments = $post->comments->map(function ($comment) {
          $comment->user->is_following = Follow::where('followed_id', $comment?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
          $comment->my_react = $comment->ReactsTheComment()->where('user_id', auth('api')->id())?->first() ?? null;
          $comment->reacts_the_comment = $comment->ReactsTheComment->map(function ($react) {
            $react->user->is_following =  Follow::where('followed_id', $react?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
          });
        });
        return $post;
      });
    //   return $ownPosts;

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


  public function allAds(Request $request): mixed
  {

    $Paginate_Size = $request->query('paginateSize') ?? 10;
    $ownPosts = Post::with($this->Relations)
      //   ->where('is_Active', 1)
      ->where('status', PostTypeEnum::ADVERTISE)
      ->get()
      ->map(function ($post) {
        $post->views_count = $post->views()->count();
        $post->makeHidden([
          'views'
        ]);
        $post->type = 'original';
        $post->user->is_following = Follow::where('followed_id', $post?->user->id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        $post->my_react = $post->reacts()->where('user_id', auth('api')->id())?->first() ?? null;
        $post->reacts = $post->reacts->map(function ($react) {
          $react->user->is_following = Follow::where('followed_id', $react->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        });
        $post->comments = $post->comments->map(function ($comment) {
          $comment->user->is_following = Follow::where('followed_id', $comment?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
          $comment->my_react = $comment->ReactsTheComment()->where('user_id', auth('api')->id())?->first() ?? null;
          $comment->reacts_the_comment = $comment->ReactsTheComment->map(function ($react) {
            $react->user->is_following =  Follow::where('followed_id', $react?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
          });
        });
        return $post;
      });
    //   return $ownPosts;

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
    // dd($request);
    if ($request['type'] == PostTypeEnum::ADVERTISE) {
      return $this->postservice->addPostAdertise($request);
    } else {
      return $this->postservice->addPostNormal($request);
    }
  }

  public function show($Post_Id): mixed
  {
    return Post::whereId($Post_Id)->first();
  }

  public function update(PostRequest $request, $Post_Id)
  {
    // dd($request);
    if ($request['type'] == PostTypeEnum::ADVERTISE) {
      return $this->postservice->updatePostAdertise($request, $Post_Id);
    } else {
      return $this->postservice->updatePostNormal($request, $Post_Id);
    }
  }

  public function get(Request $request, $User_Id)
  {
    $Paginate_Size = $request->query('paginateSize') ?? 10;
    $User = Member::find($User_Id);
    $posts = $User->posts()->where('status', PostTypeEnum::NORMAL)
      ->orWhere(function ($query) use ($User_Id) {
        $query->where('status', PostTypeEnum::ADVERTISE)->where('user_id', $User_Id)
          ->whereHas('adsStatus', function ($q) {
            $q->where('status', AdsStatusEnum::APPROVED);
          });
      });
    $ownPosts = $posts->with($this->Relations)
      //   ->where('is_Active', 1)
      ->get()
      ->map(function ($post) {
        if ($post->status === PostTypeEnum::NORMAL) {
          $post->makeHidden([
            'resolution',
            'start_time',
            'end_time',
            'start_date',
            'end_date',
            'period',
            'adsStatus',
            'views'
          ]);
        } elseif ($post->status === PostTypeEnum::ADVERTISE) {
          $post->views_count = $post->views()->count();
          $post->makeHidden([
            'views'
          ]);
        }
        $post->type = 'original';
        $post->user->is_following = Follow::where('followed_id', $post?->user->id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        $post->my_react = $post->reacts()->where('user_id', auth('api')->id())?->first() ?? null;
        $post->reacts = $post->reacts->map(function ($react) {
          $react->user->is_following = Follow::where('followed_id', $react->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        });
        $post->comments = $post->comments->map(function ($comment) {
          $comment->user->is_following = Follow::where('followed_id', $comment?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
          $comment->my_react = $comment->ReactsTheComment()->where('user_id', auth('api')->id())?->first() ?? null;
          $comment->reacts_the_comment = $comment->ReactsTheComment->map(function ($react) {
            $react->user->is_following =  Follow::where('followed_id', $react?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
          });
        });
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

  public function delete($Post_Id): mixed
  {
    Post::whereId($Post_Id)->delete();
    return response()->json(['message' => 'تم حذف المنشور بنجاح'], 200);
  }


  public function getMyPosts(Request $request)
  {
    $posts = auth('api')->user()->posts()->where('status', PostTypeEnum::NORMAL)
      ->orWhere(function ($query) {
        $query->where('status', PostTypeEnum::ADVERTISE)->where('user_id', auth('api')->id())
          ->whereHas('adsStatus', function ($q) {
            $q->where('status', AdsStatusEnum::APPROVED);
          });
      });


    $ownPosts = $posts->with($this->Relations)
      ->orderByDesc('id')
      ->get()
      ->map(function ($post) {
        if ($post->status === PostTypeEnum::NORMAL) {
          $post->makeHidden([
            'resolution',
            'start_time',
            'end_time',
            'start_date',
            'end_date',
            'period',
            'adsStatus',
            'views'
          ]);
        } elseif ($post->status === PostTypeEnum::ADVERTISE) {
          $post->views_count = $post->views()->count();
          $post->makeHidden([
            'views'
          ]);
        }
        $post->type = 'original';
        $post->user->is_following = Follow::where('followed_id', $post?->user->id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        $post->my_react = $post->reacts()->where('user_id', auth('api')->id())?->first() ?? null;
        $post->reacts = $post->reacts->map(function ($react) {
          $react->user->is_following = Follow::where('followed_id', $react->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        });
        $post->comments = $post->comments->map(function ($comment) {
          $comment->user->is_following = Follow::where('followed_id', $comment?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
          $comment->my_react = $comment->ReactsTheComment()->where('user_id', auth('api')->id())?->first() ?? null;
          $comment->reacts_the_comment = $comment->ReactsTheComment->map(function ($react) {
            $react->user->is_following =  Follow::where('followed_id', $react?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
          });
        });
        return $post;
      });

    $Paginate_Size = $request->query('paginateSize') ?? 10;
    return $ownPosts->customPaginate($Paginate_Size);
  }



  public function showSharesOfPost(Request $request, $Post)
  {
    $Paginate_Size = $request->query('paginateSize') ?? 10;
    return SharedPost::where('post_id', $Post)->with('userShared')->orderByDesc('id')->paginate($Paginate_Size);
  }


public function addPostIntro(Request $request)
{
    $request->validate([
        'file_name' => 'required|file|mimes:mp4,avi,mov',
    ]);

    $file = $request->file('file_name');
    $extension = strtolower($file->getClientOriginalExtension());

    if (in_array($extension, ['mp4', 'avi', 'mov'])) {
        $getID3 = new \getID3;
        $analysis = $getID3->analyze($file->getRealPath());

        if (isset($analysis['playtime_seconds']) && $analysis['playtime_seconds'] > 60) {
            return response()->json(['message' => 'مدة الفيديو يجب أن لا تتجاوز 60 ثانية'], 422);
        }
    }
      // dd(auth('api')->user()->id);
    // ✅ حفظ الملف مؤقتًا
    $path = Storage::disk('public')->putFile('posts', $file);
    $fileName = pathinfo($path, PATHINFO_FILENAME); // بدون الامتداد

    // ✅ تنفيذ التحويل في الخلفية
    UploadIntroVideoJob::dispatch($path, auth('api')->user()->id);

    return response()->json([
        'message' => 'تم رفع الفيديو وسيتم معالجته في الخلفية',
        // 'file_url' => asset('storage/' . $path),
    ], 200);
}






  public function getPostIntro($id)
  {
    return  Intro::where('id', $id)
      ->first();
  }

  //  

  public function deletePostIntro($id)
  {
    $intro = Intro::where('id', $id)
      ->first();
    Storage::delete('posts/' . $intro?->file_name);
    $intro->delete();

    return response()->json(['message' => 'تمت الحذف بنجاح'], 200);
  }


  public function addView(Request $request, $postId): JsonResponse
  {
    $userId = auth('api')->id();
    $post = Post::findOrFail($postId);

    if (!$post) {
      return response()->json(['message' => 'Post not found'], 404);
    }
    $post->views()->updateOrCreate(['user_id' => $userId]);
    return response()->json(['message' => 'Video view recorded successfully'], 200);
  }
}
