<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Post;

class EmployeeController extends Controller
{
    public function __construct(protected PostResource $PostResource){}




    public function getPosts(){

        $posts=Post::orderbyraw('is_follow','desc')->get();
    
        return $this->PostResource::collection($posts);
        
        }




}
