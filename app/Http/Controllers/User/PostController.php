<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
class PostController extends Controller
{
    public function __construct(protected PostResource $PostResource){}

      public function addPost(Request $request){
         
        if(empty($request->content) || empty($request->file_name)){
            return __('لم يتم انشاء المنشور  الرجاء المحاولة مرة اخرى ');
        }

        $companies=Company::pluck('id')->toArray();
        $user=auth()->user();
        abort_if(!in_array($user->id, $companies), 403, __('ليس لديك صلاحيات لتنفيذ هذه العملية'));

        $post=Post::create([
            'content'=>$request->content,
            'company_id'=>auth()->user()->id,
        ]);
       
        if(!empty($request->file_name)){
            $fileName=uniqid().'.'.$request->file_name->getClientOriginalExtension();
            $file_path=Storage::disk('local')->putFileAs('', $request->file_name, $fileName);
        }

        return $this->PostResource::make($post) ?? [];
          
      }




    public function getPosts(){

        $posts=Post::with(['Company','Review'])->orderbyraw('is_follow','desc')->get();
    
        return $this->PostResource::collection($posts) ?? [];
        
        }

        public function getPost(Post $post){

        $post=Post::whereId($post->id)->load(['Company','Review'])->first();

        return $this->PostResource::make($post) ?? [];
            
        }

    

}
