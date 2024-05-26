<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Post;

class EmployeeController extends Controller
{
    public function __construct(protected PostResource $PostResource){}




    public function getPosts(){

        $posts=Post::with(['Company','Review'])->orderbyraw('is_follow','desc')->get();
    
        return $this->PostResource::collection($posts) ?? [];
        
        }

        public function getPost(Post $post){

        $post=Post::whereId($post->id)->load(['Company','Review'])->first();

        return $this->PostResource::make($post) ?? [];
            
        }





}
