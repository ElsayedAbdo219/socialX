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
  SponserController,
  PromotionController,
  AdsPriceController
};
use App\Jobs\MergeChunkAdsJob;
use App\Jobs\UploadAdsJob;
// use App\Http\Requests\Api\V1\Client\mergeChunkAdsRequest;
use App\Http\Requests\Api\V1\Client\uploadChunkAdsRequest;
use Illuminate\Http\Request;

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

Route::get('/', function () {
  return view('welcome');
});


#test large files 
Route::get('/uploadVid', function () {
  return view('chunkVideo');
});


# upload chunck 
Route::post('/chunk', function (uploadChunkAdsRequest $request) {
  $request->validated();

  $fileName = $request->input('file_name');
  $chunkNumber = $request->input('chunk_number');
  $chunk = $request->file('chunk');
  // dd($chunk);
  $tempPath = $chunk->storeAs("temp/chunks/{$fileName}", $chunkNumber);
  // dd($tempPath);

  UploadAdsJob::dispatch(storage_path("app/{$tempPath}"), $fileName, $chunkNumber);
  // return $tempPath;
  return response()->json(['message' => 'Chunk uploaded']);
});


Route::post('/merge', function (Request $request) {
    $request->validate([
        'file_name' => ['required', 'string']
    ]);

    $fileName = basename($request->input('file_name'));
    $cleanName = preg_replace('/_\d+$/', '', $fileName);
    // dd($cleanName);
    $chunkPath = storage_path("app/temp/chunks/{$fileName}");
    $finalPath = storage_path("app/public/posts/{$fileName}");
    //  dd($chunkPath, $finalPath);

    if (!file_exists($chunkPath)) {
        return response()->json(['error' => 'لم يتم العثور على الأجزاء'], 404);
    }
    MergeChunkAdsJob::dispatch($chunkPath, $finalPath);


    // dd($cleanName);
    return response()->json([
        'message' => 'جاري الدمج',
        'file_path' => "storage/posts/{$cleanName}"
    ]);
});



// Route::get('/form-map', function () {
//    return view('form-map');
// });


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

    Route::post('/admin/set-language', function (Illuminate\Http\Request $request) {
      $lang = $request->input('lang');

      if (in_array($lang, ['en', 'ar'])) {
        session(['locale' => $lang]);
      }
      return redirect()->back();
    })->name('setLanguage');



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
    # sponsers
    Route::resource('sponsers', SponserController::class);
      Route::post('/sponsers/update-order', [SponserController::class, 'updateOrder'])->name('admin.sponsers.updateOrder');

    # promotions
    Route::resource('promotions', PromotionController::class);
    Route::get('admin/promotions/addUser/{id}', [PromotionController::class, 'addUser'])->name('promotions.addUser');

    # ads price 
    Route::resource('Ads-price', AdsPriceController::class);


    //  # bitcoin-stock
    //  Route::get('bitcoin-stock', function(){
    //   return view('bitcoin');
    //  });

  });
});

// composer create-project --prefer-dist laravel/laravel chatapp
