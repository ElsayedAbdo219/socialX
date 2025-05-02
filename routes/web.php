<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacebookController;

use App\Http\Controllers\Dashboard\{
   AuthController,
   SettingController,
   CompanyController,
   EmployeeController,
   PostController,
   NewController,
   FrequentlyQuestionedAnswerController,
   ComplainController,
   testController,
   ProfileController,
   JobController,
   AdvertiseController,
   PaymobController,
   SkillController,
   CategoryController,
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//    return view('map');
// });

Route::get('/form-map', function () {
   return view('form-map');
});


///  payment paymob
// Route::get('/credit', [PaymobController::class, 'credit'])->name('payment');
// Route::get('/callback', [PaymobController::class, 'callback'])->name('payment');
// Route::get('/payment',[PaymobController::class,'payment'])->name('payment');


Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);




Route::name('admin.')->prefix('admin')->group(function () {
   Route::get('/adminDash-Login', [AuthController::class, 'loginASview'])->name('login');
   Route::post('/adminDash-Login', [AuthController::class, 'login'])->name('startSession');


   Route::middleware(['auth:web'])->group(function () {
      Route::get('/home', [AuthController::class, 'home'])->name('home');
      Route::get('/markered', [AuthController::class, 'markered'])->name('notification.markAsRead');
      Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
      Route::get('/edit', [AuthController::class, 'edit'])->name('profile.edit');


      # Profile
      Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
      Route::patch('profile/edit-personal', [ProfileController::class, 'updatePersonal'])->name('profile.personal.update');
      Route::patch('profile/edit-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');



      # Settings
      Route::name('settings.')->prefix('settings')->group(function () {
         Route::get('settings', [SettingController::class, 'index'])->name('index');
         Route::patch('update/{setting}', [SettingController::class, 'update'])->name('update');
      });

      # Companies
      Route::resource('companies', CompanyController::class);


      # Employee
      Route::resource('employees', EmployeeController::class);

      # posts
      Route::resource('posts', PostController::class);

      # News
      Route::resource('news', NewController::class);

      # FQA
      Route::resource('fqa', FrequentlyQuestionedAnswerController::class);

      # Complain
      Route::resource('complain', ComplainController::class);

      # jobs
      Route::resource('jobs', JobController::class);

      # advertises
      Route::resource('advertises', AdvertiseController::class);

      # category
      Route::resource('categories', CategoryController::class);
     # skills
     Route::resource('skills', SkillController::class);

      

   });
});

// 
// composer create-project --prefer-dist laravel/laravel chatapp
