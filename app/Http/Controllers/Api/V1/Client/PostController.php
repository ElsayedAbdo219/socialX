<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Post;
use App\Models\User;
use App\Models\Intro;
use App\Models\Follow;
use App\Models\Member;
use App\Models\AdsPrice;
use App\Models\Promotion;
use App\Enum\PostTypeEnum;
use App\Jobs\UploadAdsJob;
use App\Models\SharedPost;
use App\Enum\AdsStatusEnum;
use Illuminate\Http\Request;
use App\Services\PostService;
use FFMpeg\Format\Video\X264;
use App\Jobs\MergeChunkAdsJob;
use App\Traits\ApiResponseTrait;
use App\Jobs\UploadIntroVideoJob;
use Illuminate\Http\JsonResponse;
use App\Models\PromotionResolution;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;
use Illuminate\Support\Facades\Notification;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use App\Http\Requests\Api\V1\Client\PostRequest;
use App\Http\Requests\Api\V1\Client\mergeChunkAdsRequest;
use App\Http\Requests\Api\V1\Client\uploadChunkAdsRequest;

class PostController extends Controller
{
  use ApiResponseTrait;

  protected $postResource = PostResource::class;
  protected $postservice;
  private $Relations = ['user', 'views', 'comments.user', 'comments.commentsPeplied.user', 'comments.ReactsTheComment.user', 'reacts.user'];

  public function __construct(PostService $postservice)
  {
    $this->postservice = $postservice;
  }

  # upload chunck 
  public function uploadChunk(uploadChunkAdsRequest $request)
  {
    $request->validated();

    $fileName = $request->input('file_name');
    $chunkNumber = $request->input('chunk_number');
    $chunk = $request->file('chunk');
    // dd($chunk);
    $tempPath = $chunk->storeAs("temp/chunks/{$fileName}", $chunkNumber);
    // dd($tempPath);

    UploadAdsJob::dispatch(storage_path("app/{$tempPath}"), $fileName, $chunkNumber);
    // return $tempPath;
    return response()->json(['message' => 'Chunk uploaded']);
  }


  public function mergeChunks(Request $request)
  {
    $request->validate([
      'file_name' => ['required', 'string']
    ]);

    $fileName = basename($request->input('file_name'));
    $cleanName = preg_replace('/_\d+$/', '', $fileName);
    $chunkPath = storage_path("app/temp/chunks/{$fileName}");
    // dd($cleanName, $chunkPath);
    $finalPath = storage_path("app/public/posts/{$cleanName}");
    // dd($finalPath , $request->input('file_name'));
    // if (!file_exists($chunkPath)) {
    //   return response()->json(['error' => 'لم يتم العثور على الأجزاء'], 404);
    // }

    MergeChunkAdsJob::dispatch($chunkPath, $finalPath);

    return response()->json([
      'message' => 'جاري الدمج',
      'file_path' => "storage/posts/{$cleanName}"
    ]);
  }

  public function all(Request $request): mixed
  {
    $Paginate_Size = $request->query('paginateSize') ?? 10;

    // البوستات الأصلية
    $ownPosts = Post::with($this->Relations)
      ->where(function ($query) {
        $query->where('status', PostTypeEnum::NORMAL)
          ->orWhere(function ($q) {
            $q->where('status', PostTypeEnum::ADVERTISE)
              ->whereHas('adsStatus', function ($q2) {
                $q2->where('status', AdsStatusEnum::APPROVED);
              });
          });
      })
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
        $post->unique_id = 'original_' . $post->id;
        if ($post->user) {
          $post->user->is_following = Follow::where('followed_id', $post?->user->id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        }
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

    // كل الشيرد بوستات
    $sharedPosts = SharedPost::with(['post' => function ($q) {
      $q->with($this->Relations);
    }, 'userShared'])->get()
      ->map(function ($sharedPost) {
        $shared = $sharedPost->post;
        $sharedPostId = $sharedPost->id;
        // dd($sharedPostId) ;
        if ($shared) {
          $sharedClone = clone $shared;
          $sharedClone->type = 'shared';
          $sharedClone->my_react = $sharedClone->reacts()->where('user_id', auth('api')->id())?->first() ?? null;
          $sharedClone->reacts = $sharedClone->reacts->map(function ($react) {
          $react->user->is_following = Follow::where('followed_id', $react->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        });
          $sharedClone->comments = $sharedClone->comments->map(function ($comment) {
            $comment->user->is_following = Follow::where('followed_id', $comment?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
            $comment->my_react = $comment->ReactsTheComment()->where('user_id', auth('api')->id())?->first() ?? null;
            $comment->reacts_the_comment = $comment->ReactsTheComment->map(function ($react) {
              $react->user->is_following =  Follow::where('followed_id', $react?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
            });
          });
          $sharedClone->unique_id = 'shared_' . $shared->id . '_by_' . $sharedPost->user_id . '_order_' . $sharedPostId;
          $sharedClone->comment = $sharedPost->comment;
          $sharedClone->sharedPerson = $sharedPost->userShared;
          return $sharedClone;
        }
        return null;
      })
      ->filter();

    $allPosts = collect();
    $allPosts = $allPosts->merge($ownPosts);
    $allPosts = $allPosts->merge($sharedPosts);
    $allPosts = $allPosts->sortByDesc('created_at')->values();
    return $allPosts->customPaginate($Paginate_Size);
  }





  public function allAds(Request $request): mixed
  {

    $Paginate_Size = $request->query('paginateSize') ?? 10;
    $ads = Post::with($this->Relations)
      //   ->where('is_Active', 1)
      ->where('status', PostTypeEnum::ADVERTISE)
      ->when($status = $request->query('status'), function ($q1) use ($status) {
        $q1->whereHas('adsStatus', function ($q2) use ($status) {
          $q2->where('status', $status);
        });
      })
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
    // dd($ads);

    // البوستات المشتركة (بنستخدم post()->with()->first())
    $sharedPosts = SharedPost::with('userShared')->get()->map(function ($sharedPost) {
      $shared = $sharedPost->post()->with($this->Relations)->first();
      if ($shared) {
        $shared->type = 'shared';
        $shared->comment = $sharedPost->comment;
        $shared->sharedPerson = $sharedPost->userShared;
        return $shared;
      }
    })->filter();

    // دمج الكولكشنز
    $allPosts = collect([$ads, $sharedPosts])
      ->collapse()
      ->sortByDesc('created_at')
      ->values();

    return $allPosts->customPaginate($Paginate_Size);
  }


  public function myAds(Request $request): mixed
  {

    $Paginate_Size = $request->query('paginateSize') ?? 10;
    $ads = auth('api')->user()->posts()->with($this->Relations)
      //   ->where('is_Active', 1)
      ->where('status', PostTypeEnum::ADVERTISE)
      ->when($status = $request->query('status'), function ($q1) use ($status) {
        $q1->whereHas('adsStatus', function ($q2) use ($status) {
          $q2->where('status', $status);
        });
      })
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

    // دمج الكولكشنز
    $allPosts = collect([$ads])
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

  public function show($Post_Unique_Id)
  {
    // shared_22_by_4_order_3
    $type = explode('_', $Post_Unique_Id)[0] ?? null;
    $Post_Id = str_replace(['original_', 'shared_'], '', $Post_Unique_Id);
    $Post_Id = explode('_', $Post_Id)[0];
    $order = explode('_', $Post_Unique_Id)[5] ?? null;
    $userBy = explode('_', $Post_Unique_Id)[3] ?? null;
    // dd($type ,$Post_Id , $order,$userBy);

    // $postShares = $post?->shares()->get();

    if ($type === 'shared') {
      $post = Post::whereId($Post_Id)->whereHas("shares", function ($q) use ($order) {
        $q->where('id', $order);
      })
        ->with($this->Relations)->first();
      //  dd($post->count());
      $post->type = 'shared';
      $post->unique_id = 'shared_' . $post->id . '_by_' . $post->user_id . '_order_' . $order;
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
      $post->sharedPerson = $post->shares->map(function ($share) {
        return $share->userShared;
      })->first();
    } else {
      $post = Post::whereId($Post_Id)->with($this->Relations)->first();
      $post->type = 'original';
      $post->unique_id = 'original_' . $post->id;
      $post->my_react = $post->reacts()->where('user_id', auth('api')->id())?->first() ?? null;
    }
    return $post;
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
    // البوستات الأصلية
    $ownPosts = $User?->posts()->with($this->Relations)
      ->where(function ($query) {
        $query->where('status', PostTypeEnum::NORMAL)
          ->orWhere(function ($q) {
            $q->where('status', PostTypeEnum::ADVERTISE)
              ->whereHas('adsStatus', function ($q2) {
                $q2->where('status', AdsStatusEnum::APPROVED);
              });
          });
      })
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
        $post->unique_id = 'original_' . $post->id;
        if ($post->user) {
          $post->user->is_following = Follow::where('followed_id', $post?->user->id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        }
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

    // كل الشيرد بوستات
    $sharedPosts = $User?->shares()->with(['post' => function ($q) {
      $q->with($this->Relations);
    }, 'userShared'])->get()
      ->map(function ($sharedPost) {
        $shared = $sharedPost->post;
        $sharedPostId = $sharedPost->id;
        // dd($sharedPostId) ;
        if ($shared) {
          $sharedClone = clone $shared;
          $sharedClone->type = 'shared';
          $sharedClone->my_react = $sharedClone->reacts()->where('user_id', auth('api')->id())?->first() ?? null;
          $sharedClone->reacts = $sharedClone->reacts->map(function ($react) {
          $react->user->is_following = Follow::where('followed_id', $react->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        });
        $sharedClone->comments = $sharedClone->comments->map(function ($comment) {
          $comment->user->is_following = Follow::where('followed_id', $comment?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
          $comment->my_react = $comment->ReactsTheComment()->where('user_id', auth('api')->id())?->first() ?? null;
          $comment->reacts_the_comment = $comment->ReactsTheComment->map(function ($react) {
            $react->user->is_following =  Follow::where('followed_id', $react?->user_id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
          });
        });
          $sharedClone->unique_id = 'shared_' . $shared->id . '_by_' . $sharedPost->user_id . '_order_' . $sharedPostId;
          $sharedClone->comment = $sharedPost->comment;
          $sharedClone->sharedPerson = $sharedPost->userShared;
          return $sharedClone;
        }
        return null;
      })
      ->filter();

    $allPosts = collect();
    $allPosts = $allPosts->merge($ownPosts);
    $allPosts = $allPosts->merge($sharedPosts);
    $allPosts = $allPosts->sortByDesc('created_at')->values();
    return $allPosts->customPaginate($Paginate_Size);
  }

  public function delete($Post_Id): mixed
  {
    Post::whereId($Post_Id)->delete();
    return response()->json(['message' => 'تم حذف المنشور بنجاح'], 200);
  }


  public function getMyPosts(Request $request)
  {
    $Paginate_Size = $request->query('paginateSize') ?? 10;

    // البوستات الأصلية
    $ownPosts = auth('api')->user()->posts()->with($this->Relations)
      ->where(function ($query) {
        $query->where('status', PostTypeEnum::NORMAL)
          ->orWhere(function ($q) {
            $q->where('status', PostTypeEnum::ADVERTISE)
              ->whereHas('adsStatus', function ($q2) {
                $q2->where('status', AdsStatusEnum::APPROVED);
              });
          });
      })
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
        $post->unique_id = 'original_' . $post->id;
        if ($post->user) {
          $post->user->is_following = Follow::where('followed_id', $post?->user->id)->where('follower_id', auth('api')->id())?->first()?->exists() ? true : false;
        }
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

    // كل الشيرد بوستات
    $sharedPosts = SharedPost::where('user_id', auth('api')->id())->with(['post' => function ($q) {
      $q->with($this->Relations);
    }, 'userShared'])->get()
      ->map(function ($sharedPost) {
        $shared = $sharedPost->post;
        $sharedPostId = $sharedPost->id;
        // dd($sharedPostId) ;
        if ($shared) {
          $sharedClone = clone $shared;
          $sharedClone->type = 'shared';
          $sharedClone->my_react = $sharedClone->reacts()->where('user_id', auth('api')->id())?->first() ?? null;
          $sharedClone->unique_id = 'shared_' . $shared->id . '_by_' . $sharedPost->user_id . '_order_' . $sharedPostId;
          $sharedClone->comment = $sharedPost->comment;
          $sharedClone->sharedPerson = $sharedPost->userShared;
          return $sharedClone;
        }
        return null;
      })
      ->filter();

    $allPosts = collect();
    $allPosts = $allPosts->merge($ownPosts);
    $allPosts = $allPosts->merge($sharedPosts);
    $allPosts = $allPosts->sortByDesc('created_at')->values();
    return $allPosts->customPaginate($Paginate_Size);
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

    $getID3 = new \getID3;
    $analysis = $getID3->analyze($file->getRealPath());

    if (isset($analysis['playtime_seconds']) && $analysis['playtime_seconds'] > 60) {
      return response()->json(['message' => 'مدة الفيديو يجب أن لا تتجاوز 60 ثانية'], 422);
    }

    $fileName = pathinfo($file, PATHINFO_FILENAME);
    $convertedFileName = $fileName . '-converted.mp4';
    $convertedPath = 'posts/' . $convertedFileName;

    \FFMpeg::fromDisk('public')
      ->open($file)
      ->export()
      ->toDisk('public')
      ->inFormat(new \FFMpeg\Format\Video\X264('aac', 'libx264'))
      ->resize(854, 480)
      ->save($convertedPath);

    Storage::disk('public')->delete($file);

    $getID3 = new \getID3;
    $convertedAnalysis = $getID3->analyze(Storage::disk('public')->path($convertedPath));
    $duration = $convertedAnalysis['playtime_seconds'] ?? null;

    Intro::updateOrCreate(
      ['company_id' => auth('api')->id()],
      ['file_name' => $convertedFileName]
    );

    $admin = User::first();
    Notification::send($admin, new ClientNotification([
      'title' => "إضافة فيديو تقديمي جديد",
      'body' => "تمت إضافة فيديو من شركة " . (User::find(auth('api')->id())->full_name ?? 'Unknown'),
    ], ['database', 'firebase']));

    return response()->json([
      'message' => 'تم رفع الفيديو وسيتم معالجته في الخلفية',
    ]);
  }

  // APP_KEY=base64:ZAikfaJtetQYdDysb5TXAl9qHXPniWMIkvitwDie2Mk=
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

  # updated
  public function checkData(Request $request)
  {
    $request->validate([
      'coupon_code' => ['required', 'string'],
    ]);

    $promotion = Promotion::where('name', $request['coupon_code'])->first();

    if (!$promotion) {
      return $this->respondWithError('Invalid Coupon Code.');
    }

    if ($promotion->is_active == 0) {
      return $this->respondWithError('Coupon Code is not active currently.');
    }

    if (empty($promotion->days_count) && \Carbon\Carbon::now()->greaterThan($promotion->end_date)) {
      return $this->respondWithError('You have exceeded the available period!');
    }

    $thePrice = 500;

    return response()->json([
      'price' => $thePrice,
      'priceafterDiscount' => $thePrice - ($thePrice * ($promotion->discount / 100)),
      'percentage' => (int)$promotion->discount . "%",
    ]);
  }

  public function getPromotionResolutions($promotionName)
  {
    $promotion = Promotion::where('name', $promotionName)->first();
    return PromotionResolution::where('promotion_id', $promotion->id)->select('id', 'resolution_number')->first();
  }

  public function getprices(Request $request)
  {
    $paginateSize = $request->query("paginateSize", 10);
    return AdsPrice::paginate($paginateSize);
  }
}
