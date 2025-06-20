<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Post;
use App\Models\Follow;
use App\Models\Member;
use App\Enum\PostTypeEnum;
use App\Enum\UserTypeEnum;
use App\Models\SharedPost;
use App\Enum\AdsStatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
  private $Relations = ['user', 'views', 'comments.user', 'comments.commentsPeplied.user', 'comments.ReactsTheComment.user', 'reacts.user'];

public function search(Request $request)
{
    $paginateSize = $request->query('paginateSize') ?? 10;
    $type = $request->query('type'); 
    
    $posts = collect();
    $employees = collect();
    $companies = collect();

    if (!$type || $type === 'posts') {
        $posts = $this->searchPosts($request)->map(function ($item) {
            $item->group_type = 'posts';
            return $item;
        });
    }

    if (!$type || $type === 'employees') {
        $employees = $this->searchEmployees($request)->map(function ($item) {
            $item->group_type = 'employees';
            return $item;
        });
    }

    if (!$type || $type === 'companies') {
        $companies = $this->searchCompanies($request)->map(function ($item) {
            $item->group_type = 'companies';
            return $item;
        });
    }

    // دمج النتيجة النهائية
    $merged = collect()
        ->merge($posts)
        ->merge($employees)
        ->merge($companies)
        ->sortByDesc('created_at')
        ->values();

    // Paginate
    $paginated = $merged->customPaginate($paginateSize);

    // Group by type (تجميع حسب النوع وإرجاع الفاضيين لو مش موجودين)
    $grouped = [
        'posts' => $merged->where('group_type', 'posts')->values(),
        'employees' => $merged->where('group_type', 'employees')->values(),
        'companies' => $merged->where('group_type', 'companies')->values(),
    ];

    // ربط الـ pagination بالـ grouped
    $paginatedArray = $paginated->toArray();
    $paginatedArray['data'] = $grouped;

    return response()->json($paginatedArray);
}



public function searchPosts(Request $request)
{
    $baseQuery = Post::where(function ($query) {
        $query->where('status', PostTypeEnum::NORMAL)
            ->orWhere(function ($q) {
                $q->where('status', PostTypeEnum::ADVERTISE)
                    ->whereHas('adsStatus', function ($q2) {
                        $q2->where('status', AdsStatusEnum::APPROVED);
                    });
            });
    });

    // حاول تطبق الفلتر الأول
    $search = $request->query('search');
    $filteredQuery = clone $baseQuery;

    if ($search) {
        $filteredQuery->where('content', 'like', '%' . $search . '%');
    }

    $posts = $filteredQuery->with($this->Relations)->get();

    // لو مفيش نتيجة للبحث، رجع كل البوستات بدون فلترة
    if ($search && $posts->isEmpty()) {
        $posts = $baseQuery->with($this->Relations)->get();
    }

    $ownPosts = $posts->map(function ($post) {
        if ($post->status === PostTypeEnum::NORMAL) {
            $post->makeHidden(['resolution', 'start_time', 'end_time', 'start_date', 'end_date', 'period', 'adsStatus', 'views']);
        } elseif ($post->status === PostTypeEnum::ADVERTISE) {
            $post->views_count = $post->views()->count();
            $post->makeHidden(['views']);
        }

        $post->type = 'original';
        $post->user->is_following = Follow::where('followed_id', $post?->user->id)
            ->where('follower_id', auth('api')->id())
            ?->exists() ?? false;

        $post->my_react = $post->reacts()->where('user_id', auth('api')->id())->first();

        $post->reacts = $post->reacts->map(function ($react) {
            $react->user->is_following = Follow::where('followed_id', $react->user_id)
                ->where('follower_id', auth('api')->id())
                ?->exists() ?? false;
        });

        $post->comments = $post->comments->map(function ($comment) {
            $comment->user->is_following = Follow::where('followed_id', $comment?->user_id)
                ->where('follower_id', auth('api')->id())
                ?->exists() ?? false;

            $comment->my_react = $comment->ReactsTheComment()->where('user_id', auth('api')->id())->first();

            $comment->reacts_the_comment = $comment->ReactsTheComment->map(function ($react) {
                $react->user->is_following = Follow::where('followed_id', $react?->user_id)
                    ->where('follower_id', auth('api')->id())
                    ?->exists() ?? false;
            });
        });

        return $post;
    });

    // Shared posts
    $sharedPosts = SharedPost::with('userShared')
        ->when($search, function ($query) use ($search) {
            $query->whereHas('post', function ($q) use ($search) {
                $q->where('content', 'like', '%' . $search . '%');
            });
        })
        ->get()
        ->map(function ($sharedPost) {
            $shared = $sharedPost->post()->with($this->Relations)->first();
            if ($shared) {
                $shared->type = 'shared';
                $shared->sharedPerson = $sharedPost->userShared;
                return $shared;
            }
        })
        ->filter();

    return collect([$ownPosts, $sharedPosts])->collapse()
        ->sortByDesc('created_at')
        ->unique('id')
        ->values();
}


  public function searchEmployees(Request $request)
  {
    $search = $request->query('search');

    $query = Member::where('type', UserTypeEnum::EMPLOYEE)
      ->with(['followersTotal', 'followedTotal', 'userCover', 'Intros', 'skills', 'employeeOverview']);

    if ($search) {
      $cloned = clone $query;

      $matched = $cloned->where(function ($q) use ($search) {
        $q->where('first_name', 'like', '%' . $search . '%')
          ->orWhere('last_name', 'like', '%' . $search . '%');
      })->get();

      if ($matched->isNotEmpty()) {
        return $matched;
      }
    }

    return $query->get();
  }



  public function searchCompanies(Request $request)
  {
    $search = $request->query('search');

    $baseQuery = Member::where('type', UserTypeEnum::COMPANY)
      ->with(['followersTotal', 'followedTotal', 'userCover', 'Intros', 'skills', 'employeeOverview']);

    if ($search) {
      $filtered = (clone $baseQuery)->where('full_name', 'like', '%' . $search . '%')->get();

      if ($filtered->isNotEmpty()) {
        return $filtered;
      }
    }

    return $baseQuery->get();
  }

}
