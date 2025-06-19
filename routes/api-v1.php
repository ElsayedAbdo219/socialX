<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Jobs\StoreUploadedFileJob;
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
  UserCoverController,
  CommentController,
  SharedPostController,
  ReactController, 
  ReactCommentController,
  CommentReplyController,
  ProjectController,
  OverViewController,
  ReportController,
  PostReportController,
  SponserController,
  PromotionController,
  PollNewsController

               






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
#test ci cd By Deploy Key 2222HiElsayed, Hello users#
#Auth updated 
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
// 
#test yml with github actions once tesTTTTTTTTTTTTTTTTTTTTTTT!!!!!!coop
Route::middleware('auth:sanctum')->group(function () {


   ////////////////////////////////////////////////////////test ci cd ///////////////////////22222222

 #test supervisor 
// Route::post('/test-supervisor', function (Request $request) {
//     $request->validate([
//         'file' => 'required|file|max:10240',
//     ]);

//     $file = $request->file('file');
//     $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();

//     // احفظ الملف مؤقتًا داخل storage/app/uploads
//     $file->storeAs('uploads', $filename);

//     // ابعت فقط اسم الملف
//     StoreUploadedFileJob::dispatch($filename);

//     return response()->json([
//         'message' => 'File upload job dispatched!',
//         'filename' => $filename,
//     ]);
// });

  #end test
Route::prefix('auth')->group(function () {
  #Auth 
  Route::get('/me', [AuthController::class, 'me']);
  Route::post('refresh', [AuthController::class, 'refreshToken']);
  Route::post('/reset-Password', [AuthController::class, 'resetPassword']);
  Route::post('/update-info/{User_Id}', [AuthController::class, 'update']);
  Route::post('/update-Password/{User_Id}', [AuthController::class, 'updatePassword']);
  Route::post('/set-Private-account/{User_Id}', [AuthController::class, 'setPrivateAccount']);
  Route::post('/addAvatar', [AuthController::class, 'addAvatar']);
});

   # posts
Route::name('posts.')->prefix('posts')->group(function () {
    #updated
    Route::get('/', [PostController::class, 'all']); // all my posts
    Route::post('/', [PostController::class, 'add']); // ADD post
    Route::get('/{ID}', [PostController::class, 'show']); // SHOW post
    Route::post('/update/{ID}', [PostController::class, 'update']); // update post
    Route::delete('/{ID}', [PostController::class, 'delete']); // delete post
    Route::get('/user/me', [PostController::class, 'getMyPosts']); // my posts 
    Route::get('/shares/{ID}', [PostController::class, 'showSharesOfPost']); // shares for  post 
    Route::get('/user/{UserID}', [PostController::class, 'get']); // get user posts
    Route::post('/addPostIntro', [PostController::class, 'addPostIntro']); // addPostIntro
    Route::get('/getPostIntro/{id}', [PostController::class, 'getPostIntro']); // addPostIntro
    Route::delete('/deletePostIntro/{id}', [PostController::class, 'deletePostIntro']); // addPostIntro
    #chunking routes#
    Route::post('/uploadChunk', [PostController::class, 'uploadChunk']); // uploadChunk
    Route::post('mergeChunks', [PostController::class, 'mergeChunks']); // mergeChunks

    
    
});


   # projects
Route::name('projects.')->prefix('projects')->group(function () {
    #updated
    Route::get('/', [ProjectController::class, 'all']); // all  my projects
    // Route::get('/me', [ProjectController::class, 'myProjects']); // all my projects
    Route::post('/', [ProjectController::class, 'add']); // ADD project
    Route::get('/{ID}', [ProjectController::class, 'show']); // SHOW project
    Route::post('/update/{ID}', [ProjectController::class, 'update']); // update project
    Route::delete('/{ID}', [ProjectController::class, 'delete']); // delete project
    Route::get('/user/{UserID}', [ProjectController::class, 'getProjects']); // get user projects
});

# Post Shares 
Route::name('post-shared.')->prefix('post-shared')->group(function () {
  #updated
  Route::post('/', [SharedPostController::class, 'add']); // ADD post
  Route::post('/update/{ID}', [SharedPostController::class, 'update']); // update post
  Route::delete('/{ID}', [SharedPostController::class, 'delete']); // delete post
});

   # Comments
Route::name('comments.')->prefix('comments')->group(function () {
    #updated
    Route::post('/', [CommentController::class, 'add']); // ADD comment
    Route::post('/update/{ID}', [CommentController::class, 'update']); // update comment
    Route::delete('/{ID}', [CommentController::class, 'delete']); // delete comment
});

   # Reacts
Route::name('reacts.')->prefix('reacts')->group(function () {
    #updated
    Route::post('/', [ReactController::class, 'add']); // ADD react
    Route::delete('/{ID}', [ReactController::class, 'delete']); // delete react
    Route::get('/{Post_Id}', [ReactController::class, 'getReactsInfo']); // delete react
});
   # Reacts on Comments
   Route::name('comment_reacts.')->prefix('comment_reacts')->group(function () {
    #updated
    Route::post('/', [ReactCommentController::class, 'add']); // ADD comment_react
    Route::delete('/{ID}', [ReactCommentController::class, 'delete']); // delete comment_react
});

# Reacts on Comments
   Route::name('comment_replies.')->prefix('comment_replies')->group(function () {
    #updated
    Route::post('/', [CommentReplyController::class, 'add']); // ADD comment_reply
    Route::post('/update/{ID}', [CommentReplyController::class, 'update']); // update comment
    Route::delete('/{ID}', [CommentReplyController::class, 'delete']); // delete comment_reply
});   



  # Experience
Route::name('experience.')->prefix('experience')->group(function () {
    #updated
    Route::get('/', [ExperienceController::class, 'all']); // only employee_id eqaul auth userID
    Route::post('/', [ExperienceController::class, 'add']); // ADD experience
    Route::get('/{ID}', [ExperienceController::class, 'show']); // SHOW experience
    Route::patch('/{ID}', [ExperienceController::class, 'update']); // update experience
    Route::delete('/{ID}', [ExperienceController::class, 'delete']); // delete experience
    Route::get('/user/{UserID}', [ExperienceController::class, 'get']); // get user experience
    Route::get('/citiesWorked/{USERID}', [ExperienceController::class, 'getCitiesWorked']); // getCitiesWorked
    
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
      Route::get('/all', [SkillController::class, 'allSkills']); // only employee_id eqaul auth userID
      Route::post('/', [SkillController::class, 'add']); // ADD SKILL
      Route::get('/{ID}', [SkillController::class, 'show']); // SHOW SKILL
      Route::patch('/{ID}', [SkillController::class, 'update']); // update SKILL
      Route::post('/delete', [SkillController::class, 'delete']); // delete SKILL
      Route::get('/user/{UserID}', [SkillController::class, 'get']); // get user SKILL
      Route::get('/category/{CATEGORY_ID}', [SkillController::class, 'getSkillsByCatgory']); // get user SKILL
    });

      # follow
      Route::name('follow.')->prefix('follow')->group(function () {
        Route::post('add', [FollowController::class, 'add']);
        Route::post('Undo', [FollowController::class, 'Undo']);
        Route::get('followers/me', [FollowController::class, 'getFollowersMe']);
        Route::get('following/me', [FollowController::class, 'getFollowingMe']);
        Route::get('followers/user/{userId}', [FollowController::class, 'getFollowersUser']);
        Route::get('following/user/{userId}', [FollowController::class, 'getFollowingUser']);
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
          Route::get('/', [NewsController::class, 'index']);
          Route::post('yes/{id}', [NewsController::class, 'yes']);
          Route::post('no/{id}', [NewsController::class, 'no']);
        });

     # Notifications
     Route::get('showNotifications', [NotificationController::class, 'showNotifications']);
     Route::get('markAsRead/{id}', [NotificationController::class, 'markAsRead']);


     Route::get('getMemberData/{Member}', [EmployeeController::class, 'getMemberData']);
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
      Route::post('updateTheCurrentPrimary', [UserCoverController::class, 'updateTheCurrentPrimary']);
      
    });
    # overviews
    Route::name('overviews.')->prefix('overviews')->group(function () {
      Route::post('/', [OverViewController::class, 'add']);
      Route::get('/{employeeId}', [OverViewController::class, 'show']);
      Route::put('/{Id}', [OverViewController::class, 'update']);
      Route::delete('/{Id}', [OverViewController::class, 'delete']);
    });

     # overviews
    Route::name('report.')->prefix('report')->group(function () {
      Route::post('/', [ReportController::class, 'add']);
      Route::put('/{Id}', [ReportController::class, 'update']);
      Route::delete('/{Id}', [ReportController::class, 'delete']);
    });

     # overviews
    Route::name('post-report.')->prefix('post-report')->group(function () {
      Route::post('/', [PostReportController::class, 'add']);
      Route::put('/{Id}', [PostReportController::class, 'update']);
      Route::delete('/{Id}', [PostReportController::class, 'delete']);
    });


     # overviews
    Route::name('ads.')->prefix('ads')->group(function () {
      Route::get('/me', [PostController::class, 'allAds']);
      Route::post('/checkData', [PostController::class, 'checkData']);
      Route::get('/getPromotionResolutions/{promotionName}', [PostController::class, 'getPromotionResolutions']);
      Route::get('/getprices', [PostController::class, 'getprices']);
      

    });

     # analysis
    Route::name('analysis.')->prefix('analysis')->group(function () {
      Route::get('/{CompanyId}', [CompanyController::class, 'getAnalysis']);
      Route::get('/getViewsOfYear/{CompanyId}', [CompanyController::class, 'getViewsOfYear']);
      Route::get('/getfollowersOfYear/{CompanyId}', [CompanyController::class, 'getfollowersOfYear']);
      
    });

     # views
    Route::name('views.')->prefix('views')->group(function () {
      Route::post('/{adsId}', [PostController::class, 'addView']);
    });

     # sponsers
    Route::name('sponsers.')->prefix('sponsers')->group(function () {
      Route::get('/', [SponserController::class, 'index']);
    });

     # free promotions
    Route::name('free-promotions.')->prefix('free-promotions')->group(function () {
      Route::get('/', [PromotionController::class, 'getFreePromotions']);
    });

     # poll news
    Route::name('poll-news.')->prefix('poll-news')->group(function () {
      Route::get('/{id}', [PollNewsController::class, 'index']);
      Route::get('/yes/{id}', [PollNewsController::class, 'yes']);
      Route::get('/no/{id}', [PollNewsController::class, 'no']);
    });
    





}); 