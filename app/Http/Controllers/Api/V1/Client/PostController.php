<?php

namespace App\Http\Controllers\Api\V1\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
class PostController extends Controller
{
    protected $postResource=PostResource::class;

      public function addPost(Request $request){
      
        if(empty($request->content) && empty($request->file_name)){
            return ('لم يتم انشاء المنشور  الرجاء المحاولة مرة اخرى ');
        }

        $companies=Company::pluck('id')->toArray();
        $user=auth()->user();
        abort_if(!in_array($user->email , $companies), 403, __('ليس لديك صلاحيات لتنفيذ هذه العملية'));

        $post=Post::create([
            'content'=>$request->content,
            'company_id'=>auth()->user()->id,
        ]);

        if ($request->file('file_name')) {
          $file = $request->file('file_name');
          $fileName = uniqid() . '_' . $file->getClientOriginalName();
          $filePath = $file->storeAs('posts', $fileName);
           $post->update([
            'file_name'=> $fileName,
        ]);
       
      }
    
       return $this->postResource::make($post) ?? [];
          
      }




      public function getPosts(){
     //  return $post->Company;
        $posts=Post::with(['Company','Review'])->get();
        
        // ->orderbyrawDesc('is_follow','1')
    
       return $this->postResource::collection($posts) ?? [];
        
      }

        public function getPost(Post $post){

        $post=Post::whereId($post?->id)->first();
        $postWithRelations=$post->load(['Company','Review'])->first();
       if (!$post) {
           abort(404);
       }
        return $this->postResource::make($postWithRelations) ?? [];
            
    }


    public function searchPost(Request $request){

      return Post::query()->when($request->filled('keyword'), function ($query) use ($request) {
        $query->where('content', 'like', '%' . $request->keyword . '%')
        ->orwhereHas('Company', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->keyword . '%');
        });
       })->get() ?? [];
          
  }


  public function getComments(Post $post){

   $post=Post::whereId($post)->first();
   $postWithRelations=$post->load(['Review'])->first();
   if (!$post) {
       abort(404);
   }
    return $this->postResource::make($postWithRelations) ?? [];
}




  



    
    

}
