<?php

namespace App\Http\Controllers\Dashboard;

use App\Datatables\PostDatatable;
use App\Http\Requests\Dashboard\FrequentlyQuestionedAnswerRequest;
use App\Models\CommonQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;

class PostController extends Controller
{
    use ApiResponseDashboard;
    protected string $datatable = PostDatatable::class;
    protected string $routeName = 'admin.posts';
    protected string $viewPath = 'dashboard.posts.list';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->datatable::create($this->routeName)
            ->render($this->viewPath);
    }


    public function destroy(Post $post)
    {
        $post->delete();
        if (request()->expectsJson()){
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.posts.index')->with('success',__('dashboard.item deleted successfully'));
    }
}