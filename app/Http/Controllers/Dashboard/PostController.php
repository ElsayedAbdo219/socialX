<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\CommonQuestion;
use App\Datatables\PostDatatable;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use App\Http\Requests\Dashboard\FrequentlyQuestionedAnswerRequest;

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




    // edit posts advertises 
    public function edit(Post $Post)
    {

        $companies = Member::where('type','company')->get();


        return view('dashboard.advertises.edit',
            [

                'post' => $Post,
                'companies' => $companies
                
            ]

        );
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