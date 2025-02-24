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
use App\Notifications\ClientNotification;
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


        return view('dashboard.posts.edit',
            [

                'post' => $Post,
                'companies' => $companies
                
            ]

        );



        
    }



    public function update(Request $request, $postId)
    {
        
        $post = Post::findOrFail($postId);
    
        // Validate the incoming request data
        $data = $request->validate([
            'is_Active' => 'required|numeric',
        ]);
    
    
        $post->update($data);
       
        if ($request->is_Active == 1) {
            $notifabels = Member::where('id', $post->company_id)->first();
    
            if ($notifabels) {
                $notificationData = [
                    'title' => "تفعيل اعلان جديدة",
                    'body' => "تم تفعيل اعلان لك من ثقه",
                ];
    
                \Illuminate\Support\Facades\Notification::send(
                    $notifabels,
                    new ClientNotification($notificationData, ['database', 'firebase'])
                );
            }
        }
    
        return redirect()->route('admin.posts.index')->with(['success', __('dashboard.item updated successfully')]);
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