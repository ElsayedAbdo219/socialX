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
  AuthController,
  SuggestionController,
  ComplainController,
  UserCoverController
               






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
Route::post('/verify-Otp', [AuthController::class, 'verifyotp']);
Route::post('/resendOtp', [AuthController::class, 'resendOtp']);
  # Static Pages
  Route::group(['prefix' => 'static-pages'], function () {
    Route::get('about-app', [StaticPagesController::class, 'aboutApp']);
    Route::get('terms-and-conditions', [StaticPagesController::class, 'termsAndConditions']);
    Route::get('privacy-policy', [StaticPagesController::class, 'privacyPolicy']);
    Route::get('help-shape', [StaticPagesController::class, 'helpShape']);
    Route::get('ads', [StaticPagesController::class, 'ads']);
    Route::get('help', [StaticPagesController::class, 'help']);
    Route::get('contact-us', [StaticPagesController::class, 'contactUs']);
    Route::post('contact-us', [StaticPagesController::class, 'contactUsSubmit']);




  });
#test yml with github actions once
Route::middleware('auth:sanctum')->group(function () {

Route::prefix('auth')->group(function () {
  #Auth
  Route::get('/me', [AuthController::class, 'me']);
  Route::post('refresh', [AuthController::class, 'refreshToken']);
  Route::post('/reset-Password', [AuthController::class, 'resetPassword']);
});

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
    #updated
    Route::get('/', [ExperienceController::class, 'all']); // only employee_id eqaul auth userID
    Route::post('/', [ExperienceController::class, 'add']); // ADD experience
    Route::get('/{ID}', [ExperienceController::class, 'show']); // SHOW experience
    Route::patch('/{ID}', [ExperienceController::class, 'update']); // update experience
    Route::delete('/{ID}', [ExperienceController::class, 'delete']); // delete experience
    Route::get('/user/{UserID}', [ExperienceController::class, 'get']); // get user experience
  });

  

  Route::get('showMember/{member}', [PostController::class, 'showMember']);
  
  # education
  Route::name('education.')->prefix('education')->group(function () {
    #updated
    Route::get('/', [EducationController::class, 'all']); // only employee_id eqaul auth userID
    Route::post('/', [EducationController::class, 'add']); // ADD education
    Route::get('/{ID}', [EducationController::class, 'show']); // SHOW education
    Route::patch('/{ID}', [EducationController::class, 'update']); // update education
    Route::delete('/{ID}', [EducationController::class, 'delete']); // delete education
    Route::get('/user/{UserID}', [EducationController::class, 'get']); // get user education
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
    Route::get('/', [RateController::class, 'all']); // only employee_id eqaul auth userID
    Route::post('/', [RateController::class, 'add']); // ADD SKILL
    Route::get('/employee/{ID}', [RateController::class, 'showEmployee']); // SHOW SKILL
    Route::get('/company/{ID}', [RateController::class, 'showCompany']); // SHOW SKILL
    Route::patch('/{ID}', [RateController::class, 'update']); // update SKILL
    Route::delete('/{ID}', [RateController::class, 'delete']); // delete SKILL
  });

  # reviews
  Route::name('reviews.')->prefix('reviews')->group(function () {
    Route::post('addComment/{post}', [ReviewController::class, 'addComment']);
    Route::post('addLike/{post}', [LikeController::class, 'addLike']);
    Route::post('addDisLike/{post}', [DislikeController::class, 'addDisLike']);
   


  });
  

    # skills
    Route::name('skills.')->prefix('skills')->group(function () {
      Route::get('/', [SkillController::class, 'all']); // only employee_id eqaul auth userID
      Route::post('/', [SkillController::class, 'add']); // ADD SKILL
      Route::get('/{ID}', [SkillController::class, 'show']); // SHOW SKILL
      Route::patch('/{ID}', [SkillController::class, 'update']); // update SKILL
      Route::delete('/{ID}', [SkillController::class, 'delete']); // delete SKILL
      Route::get('/user/{UserID}', [SkillController::class, 'get']); // get user SKILL
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

    # compalins
    Route::name('compalins.')->prefix('compalins')->group(function () {
      Route::post('add', [ComplainController::class, 'send']);
    });

    # contact-us
   
      Route::post('contact-us', [ComplainController::class, 'send']);

     # suggestions
    Route::name('suggestions.')->prefix('suggestions')->group(function () {
      Route::post('add', [SuggestionController::class, 'send']);
    });


     # suggestions
    Route::name('suggestions.')->prefix('suggestions')->group(function () {
      Route::post('add', [SuggestionController::class, 'send']);
    });

      # usercovers
    Route::name('usercovers.')->prefix('usercovers')->group(function () {
      Route::post('add', [UserCoverController::class, 'add']);
      Route::post('show', [UserCoverController::class, 'show']);
      Route::post('update', [UserCoverController::class, 'update']);
      Route::post('delete', [UserCoverController::class, 'delete']);
    });
   


     # skills
    Route::name('usercovers.')->prefix('usercovers')->group(function () {
      Route::post('add', [UserCoverController::class, 'add']);
      Route::post('show', [UserCoverController::class, 'show']);
      Route::post('update', [UserCoverController::class, 'update']);
      Route::post('delete', [UserCoverController::class, 'delete']);
    });





     # reviews
    Route::name('usercovers.')->prefix('usercovers')->group(function () {
      Route::post('add', [UserCoverController::class, 'add']);
      Route::post('show', [UserCoverController::class, 'show']);
      Route::post('update', [UserCoverController::class, 'update']);
      Route::post('delete', [UserCoverController::class, 'delete']);
    });


     # usercovers
     Route::name('usercovers.')->prefix('usercovers')->group(function () {
      Route::post('add', [UserCoverController::class, 'add']);
      Route::post('show', [UserCoverController::class, 'show']);
      Route::post('update', [UserCoverController::class, 'update']);
      Route::post('delete', [UserCoverController::class, 'delete']);
    });


     # education
     Route::name('usercovers.')->prefix('usercovers')->group(function () {
      Route::post('add', [UserCoverController::class, 'add']);
      Route::post('show', [UserCoverController::class, 'show']);
      Route::post('update', [UserCoverController::class, 'update']);
      Route::post('delete', [UserCoverController::class, 'delete']);
    });




}); 