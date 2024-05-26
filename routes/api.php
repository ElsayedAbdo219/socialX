<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\{
    AuthController,
    PostController



};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix("auth")->group(function(){

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/register/{type}', [AuthController::class, 'register']);
    Route::post('/login/{type}', [AuthController::class, 'login']);
    Route::post('/logout/{type}', [AuthController::class, 'register']);
});

});


Route::middleware('auth:sanctum')->group(function(){
    Route::post('addPost', [PostController::class, 'addPost']);
    Route::get('addPosts', [PostController::class, 'getPosts']);
    Route::post('getPost', [PostController::class, 'getPost']);
});





