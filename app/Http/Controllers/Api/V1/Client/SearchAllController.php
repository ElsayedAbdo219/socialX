<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Post;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchAllController extends Controller
{
    // public function index(Request $request)
    // {
    //     $members = Member::when($request->search, function ($query) use ($request) {
    //         $query->where('full_name', 'like', '%' . $request->search . '%')
    //         ->orWhere('email', 'like', '%' . $request->search . '%')
    //         ->orWhere('phone', 'like', '%' . $request->search . '%')
    //         ->orWhere('first_name', 'like', '%' . $request->search . '%')
    //         ->orWhere('last_name', 'like', '%' . $request->search . '%');
    //     });
    //     $members->map(function($member){
    //        return $member->searchType = 'member';
    //     });
    //     $members = $members->get() ?? [];
    //     $posts =  Post::when($request->search, function ($query) use ($request) {
    //         $query->where('title', 'like', '%' . $request->search . '%')
    //         ->orWhere('content', 'like', '%' . $request->search . '%');
    //     });
    //     $posts->map(function($post){
    //       return $post->searchType = 'post';
    //     });
    //     $posts = $posts->get() ?? [];
    //     $data =  !empty($posts) ||  !empty($members) ? (!empty($posts) ? $posts : $members) : [];
    //     return response()->json([
    //         'message' => 'Search functionality is not yet implemented.',
    //         'data' => $data,
    //     ]);
    // }
}
