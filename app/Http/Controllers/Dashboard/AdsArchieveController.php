<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use App\Datatables\AdsArchieveDatatable;

class AdsArchieveController extends Controller
{
      use ApiResponseDashboard;
    protected string $datatable = AdsArchieveDatatable::class;
    protected string $route = 'admin.ads-archieve';
    protected string $viewPath = 'dashboard.ads-archieve.list';


    public function index()
    {
      // dd(Post::withTrashed()->count());

        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }

      public function destroy(Post $post)
    {
        $post->forceDelete();
        if (request()->expectsJson()) {
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.ads-archieve.index')->with('success', __('dashboard.item deleted successfully'));
    }
}
