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
  StaticPagesController,
  PositionController,
  SkillController,
  FollowController,
  JobController,
  UserApplyJobController,
  EmployeeController,
  NotificationController,
  CompanyController,
  LikeController,
  NewsController,
  DislikeController,
  CalenderController,
  FirebaseController,
  AuthController
               






};

use App\Http\Controllers\FawaterkController;
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


Route::post('/create-invoice', [FawaterkController::class, 'createInvoice']);
Route::post('/fawaterk/webhook', [FawaterkController::class, 'handleWebhook']);

# Status Pages 
Route::get('/payment/success', [FawaterkController::class, 'success'])->name('payment.success');
Route::get('/payment/fail', [FawaterkController::class, 'fail'])->name('payment.fail');
Route::get('/payment/pending', [FawaterkController::class, 'pending'])->name('payment.pending');


#Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forget-Password', [AuthController::class, 'forgetPassword']);
Route::post('/reset-Password', [AuthController::class, 'resetPassword']);

Route::prefix("auth")->group(function () {


  Route::name('companies.')->prefix('companies')->group(function () {
    Route::post('register', [AuthCompanyController::class, 'register']);
     Route::post('login', [AuthCompanyController::class, 'login']);
  });

  Route::name('employees.')->prefix('employees')->group(function () {
    Route::post('register', [AuthEmployeeController::class, 'register']);
    Route::post('login', [AuthEmployeeController::class, 'login']);
  });

  Route::middleware('auth:sanctum')->group(function () {


    Route::name('companies.')->prefix('companies')->group(function () {
       Route::get('logout', [AuthCompanyController::class, 'logout']);
       Route::post('forget-Passwored', [AuthCompanyController::class, 'forgetPassword']);
       Route::post('reset-password/{token}', [AuthCompanyController::class, 'resetPassword']);
       Route::post('verify-Otp', [AuthCompanyController::class, 'verifyOtp']);
       Route::get('delete-MyAccount', [AuthCompanyController::class, 'deleteMyAccount']);
       Route::post('/update', [AuthCompanyController::class, 'update']);
       Route::post('/change-password', [AuthCompanyController::class, 'changePassword']);

    });

    Route::name('employees.')->prefix('employees')->group(function () {
      Route::get('logout', [AuthEmployeeController::class, 'logout']);
      Route::post('forget-Passwored', [AuthEmployeeController::class, 'forgetPassword']);
      Route::post('reset-password/{token}', [AuthEmployeeController::class, 'resetPassword']);
      Route::post('verify-Otp', [AuthEmployeeController::class, 'verifyOtp']);
      Route::get('delete-MyAccount', [AuthEmployeeController::class, 'deleteMyAccount']);
      Route::post('/update', [AuthEmployeeController::class, 'update']);

      Route::post('/change-password', [AuthCompanyController::class, 'changePassword']);

      
    });


});


});




Route::middleware('auth:sanctum')->group(function () {

  ##############################################################################################
    # FirebaseController
    Route::name('messages.')->prefix('messages')->group(function () {
      Route::post('send', [FirebaseController::class, 'send']);
    });

    ###############################################################################################




  # Posts
  Route::post('addPost/{type}', [PostController::class, 'addPost']);
  
  Route::get('getPosts', [PostController::class, 'getPosts']);
  Route::get('getAdvertises', [PostController::class, 'getAdvertises']);
  Route::get('getPostIntro', [PostController::class, 'getPostIntro']);
  Route::post('addPostIntro', [PostController::class, 'addPostIntro']);
  
  Route::get('getPost/{post}', [PostController::class, 'getPost']);
  
  Route::post('searchPost', [PostController::class, 'searchPost']);
  Route::get('getComments/{post}', [PostController::class, 'getComments']);

  # Experience
  Route::name('experience.')->prefix('experience')->group(function () {

    Route::post('/add', [ExperienceController::class, 'add']);

    Route::get('get/{EMPLOYEE}', [ExperienceController::class, 'get']);
  });

  

  Route::get('showMember/{member}', [PostController::class, 'showMember']);
  
  # education
  Route::name('education.')->prefix('education')->group(function () {
    Route::get('get/{EMPLOYEE}', [EducationController::class, 'get']);
    Route::post('/add', [EducationController::class, 'add']);
  });

  // # position
  // Route::name('position.')->prefix('position')->group(function () {

  //   Route::post('/add', [EducationController::class, 'add']);
  // });

  # education
  # position
  Route::name('position.')->prefix('position')->group(function () {

    Route::post('/add', [PositionController::class, 'add']);
    Route::get('get/{EMPLOYEE}', [PositionController::class, 'get']);

  });

 


  # Rates
  Route::name('rate.')->prefix('rate')->group(function () {
    Route::post('/add', [RateController::class, 'add']);
    Route::get('/viewMyRate', [RateController::class, 'viewMyRate']);
    Route::get('getRate/{EMPLOYEE}', [RateController::class, 'getRate']);
  });

  # reviews
  Route::name('reviews.')->prefix('reviews')->group(function () {
    Route::post('addComment/{post}', [ReviewController::class, 'addComment']);
    Route::post('addLike/{post}', [LikeController::class, 'addLike']);
    Route::post('addDisLike/{post}', [DislikeController::class, 'addDisLike']);
   


  });
  

    # skills
    Route::name('skills.')->prefix('skills')->group(function () {
      Route::post('add', [SkillController::class, 'add']);
      Route::get('get/{EMPLOYEE}', [SkillController::class, 'get']);
    });



  # Static Pages
  Route::group(['prefix' => 'static-pages'], function () {
    Route::get('about-app', [StaticPagesController::class, 'aboutApp']);
    Route::get('terms-and-conditions', [StaticPagesController::class, 'termsAndConditions']);
    Route::get('privacy-policy', [StaticPagesController::class, 'privacyPolicy']);
    Route::get('contact-us', [StaticPagesController::class, 'contactUs']);
    Route::post('contact-us', [StaticPagesController::class, 'contactUsSubmit']);




  });


      # follow
      Route::name('follow.')->prefix('follow')->group(function () {
        Route::post('add', [FollowController::class, 'add']);
        Route::post('Undo', [FollowController::class, 'Undo']);
        
      });

       # jobs
       Route::name('jobs.')->prefix('jobs')->group(function () {
        Route::post('add', [JobController::class, 'add']);
        Route::get('get', [JobController::class, 'get']);
        // Route::post('filter', [JobController::class, 'filter']);

        
      });

      # user apply jobs
      Route::name('apply_jobs.')->prefix('apply_jobs')->group(function () {
        Route::post('add', [UserApplyJobController::class, 'add']);
        Route::get('getDetailsOfAppliers/{JOB}', [UserApplyJobController::class, 'getDetailsOfAppliers']);

      });


      # user apply jobs
      Route::name('companies.')->prefix('companies')->group(function () {
        Route::get('show', [CompanyController::class, 'index']);
      });

      # user apply jobs
      Route::name('employees.')->prefix('employees')->group(function () {
        Route::get('index', [CompanyController::class, 'indexofEmployee']);
      
      });



        # follow
        Route::name('news.')->prefix('news')->group(function () {
          Route::get('index', [NewsController::class, 'index']);
          Route::post('yes/{id}', [NewsController::class, 'yes']);
          Route::post('no/{id}', [NewsController::class, 'no']);
        });


     # Notifications
     Route::get('showNotifications', [NotificationController::class, 'showNotifications']);




     Route::get('getEmployeeData/{EMPLOYEE}', [EmployeeController::class, 'getEmployeeData']);


     Route::get('getJobs/{MEMBER}', [CompanyController::class, 'getJobs']);


  # calender
  Route::name('calender.')->prefix('calender')->group(function () {
    Route::post('add', [CalenderController::class, 'add']);
    Route::get('show', [CalenderController::class, 'show']);
    Route::get('delete/{calender}', [CalenderController::class, 'delete']);
    Route::post('update/{calender}', [CalenderController::class, 'update']);
    Route::post('changeStatus/{calender}', [CalenderController::class, 'changeStatus']);
  });

  

});