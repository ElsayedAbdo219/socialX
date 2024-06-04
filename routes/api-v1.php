<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Client\{
    AuthCompanyController,
    AuthEmployeeController,
    PostController,
    ExperienceController,
    EducationController,
    RateController,
    ReviewController,
    StaticPagesController

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


Route::name('companies.')->prefix('companies')->group(function(){
  Route::post('register', [AuthCompanyController::class, 'register']);
  Route::post('login', [AuthCompanyController::class, 'login']);
  Route::post('forget-Passwored', [AuthCompanyController::class, 'forgetPassword']);
  Route::post('reset-password/{token}', [AuthCompanyController::class, 'resetPassword']);
  Route::post('verify-Otp', [AuthCompanyController::class, 'verifyOtp']);
  Route::post('delete-MyAccount', [AuthCompanyController::class, 'deleteMyAccount']);
});

Route::name('employees.')->prefix('employees')->group(function(){
  Route::post('register', [AuthEmployeeController::class, 'register']);
  Route::post('login', [AuthEmployeeController::class, 'login']);
  Route::post('forget-Passwored', [AuthEmployeeController::class, 'forgetPassword']);
  Route::post('reset-password/{token}', [AuthEmployeeController::class, 'resetPassword']);
  Route::post('verify-Otp', [AuthEmployeeController::class, 'verifyOtp']);
  Route::post('delete-MyAccount', [AuthEmployeeController::class, 'deleteMyAccount']);
});

Route::middleware('auth:sanctum')->group(function(){


    Route::name('companies.')->prefix('companies')->group(function(){
        Route::post('/logout', [AuthCompanyController::class, 'logout']);
        Route::put('/update', [AuthCompanyController::class, 'update']);
    });

      Route::name('employees.')->prefix('employees')->group(function(){
        Route::post('/logout', [AuthEmployeeController::class, 'logout']);
        Route::put('/update', [AuthEmployeeController::class, 'update']);
    });
});

});

 
Route::middleware('auth:sanctum')->group(function(){

  # Posts
    Route::post('addPost', [PostController::class, 'addPost']);
    Route::get('getPosts', [PostController::class, 'getPosts']);
    Route::get('getPost/{post}', [PostController::class, 'getPost']);
    Route::post('searchPost', [PostController::class, 'searchPost']);
    Route::get('getComments', [PostController::class, 'getComments']);
    
   # Experience
   Route::name('experience.')->prefix('experience')->group(function(){

    Route::post('/add', [ExperienceController::class, 'add']);

     });

    # education
   Route::name('education.')->prefix('education')->group(function(){

    Route::post('/add', [EducationController::class, 'add']);

     });

      # position
   Route::name('position.')->prefix('position')->group(function(){

      Route::post('/add', [EducationController::class, 'add']);

     });

      # education
      # position
   Route::name('position.')->prefix('position')->group(function(){

    Route::post('/add', [EducationController::class, 'add']);
  });


      # Rates
    Route::name('rate.')->prefix('rate')->group(function(){
      Route::post('/add', [RateController::class, 'add']);
      Route::get('/viewMyRate/{type}', [RateController::class, 'viewMyRate']);
    });

        # reviews
    Route::name('reviews.')->prefix('reviews')->group(function(){
      Route::post('add', [ReviewController::class, 'add']);
    });



    # Static Pages
Route::group(['prefix' => 'static-pages'], function () {
  Route::get('about-app', [StaticPagesController::class, 'aboutApp']);
  Route::get('terms-and-conditions', [StaticPagesController::class, 'termsAndConditions']);
  Route::get('privacy-policy', [StaticPagesController::class, 'privacyPolicy']);
  Route::get('contact-us', [StaticPagesController::class, 'contactUs']);
  Route::post('contact-us', [StaticPagesController::class, 'contactUsSubmit']);
});

    

});





