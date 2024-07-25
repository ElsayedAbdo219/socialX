<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use App\Datatables\AdvertiseDatatable;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;

class AdvertiseController extends Controller
{
    use ApiResponseDashboard;



    protected string $datatable = AdvertiseDatatable::class;
    protected string $route = 'admin.posts';
    protected string $viewPath = 'dashboard.advertises.list';


    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }



    public function create()
    {

        $companies = Member::where('type','company')->get();

        return view('dashboard.advertises.add',[
            'companies' => $companies
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'nullable|string|max:255',
            'company_id' => 'required|exists:members,id',
            'period' => 'required|numeric',
            'is_published' => 'required|numeric',
            'file_name' => 'image|mimes:jpeg,png,jpg',

        ]);


        $data['status'] = 'advertisement';

        $post = Post::create($data);


        if ($request->file('file_name')) {
            $file = $request->file('file_name');
            $file_name = uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('companies', $file_name);
             $post->update([
              'file_name'=> $file_name,
          ]);
        }


        # sending a notification to the user   
        $notifabels = Member::where('id', $data['company_id'])->first();
        $notificationData = [
            'title' => " اضافة اعلان جديدة ",
            'body' => "تم اضافة اعلان لك من ثقه ",
        ];

        \Illuminate\Support\Facades\Notification::send(
            $notifabels,
            new ClientNotification($notificationData, ['database', 'firebase'])
        );




        return redirect()->route('admin.advertises.index')->with(['success', __('dashboard.item added successfully')]);
    }


      



    public function edit(Post $Post)
    {
        return view('dashboard.advertises.edit',
            [
                'Post' => $Post,
            ]

        );
    }

    public function update(Request $request, $postId)
    {
        // Find the post by ID or fail
        $post = Post::findOrFail($postId);
    
        // Validate the incoming request data
        $data = $request->validate([
            'content' => 'nullable|string|max:255',
            'file_name' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_Active' => 'required|numeric',
        ]);
    
        // Handle file upload if present
        if ($request->hasFile('file_name')) {
            $file = $request->file('file_name');
            $file_name = uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('companies', $file_name);
    
            // Update file_name in the post
            $post->file_name = $file_name;
        }
    
        // Update the post with the validated data
        $post->update($data);
    
        // Additional updates if a file was uploaded
        if (isset($file_name)) {
            $post->update(['file_name' => $file_name]);
        }
    
        // Send notification if post is activated
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
        if (request()->expectsJson()) {
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.advertises.index')->with('success', __('dashboard.item deleted successfully'));
    }
}
