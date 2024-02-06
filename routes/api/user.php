<?php

use App\Http\Controllers\AutomationController;
use App\Http\Controllers\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageUsersController;
use App\Http\Controllers\SubsribtionController;
use App\Models\Automations;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('categories',[CategoryController::class, 'getAllCategories'])->name('getAllCategories');
Route::get('autos',[AutomationController::class, 'getAllAutos'])->name('getAllAutos');
Route::post('autos/test',[AutomationController::class, 'test'])->name('test');
Route::post('autos/linkedinMatchData',[AutomationController::class, 'linkedinMatchData'])->name('linkedinMatchData');
Route::post('autos/followerCollector',[AutomationController::class, 'instaApiExtractor'])->name('instaApiExtractor');
Route::post('autos/followingCollector',[AutomationController::class, 'followingCollector'])->name('followingCollector');
Route::post('autos/twitterPostLiker',[AutomationController::class, 'twitterPostLiker'])->name('twitterPostLiker');
Route::post('autos/instagramPostExtractor',[AutomationController::class, 'instagramPostExtractor'])->name('instagramPostExtractor');
Route::post('autos/yellowPageSearchExtractor',[AutomationController::class, 'yellowPageSearchExtractor'])->name('yellowPageSearchExtractor');
Route::post('autos/actionUpdate',[AutomationController::class, 'automActionUpdate'])->name('automActionUpdate');
Route::post('autos/reponse',[AutomationController::class, 'responseRequest'])->name('responseRequest');
Route::get('autos/home',[CategoryController::class, 'getAllAutosHome'])->name('getAllAutosHome');
Route::get('autos/homeMobile',[CategoryController::class, 'getAllAutosHomeMobile'])->name('getAllAutosHomeMobile');
Route::get('autos/url/{url}',[AutomationController::class, 'automByUrl'])->name('automByUrl');
Route::get('autos/listByUrl/{url}',[AutomationController::class, 'automListByUrl'])->name('automListByUrl');
Route::get('autos/category/{id}',[AutomationController::class, 'getAutoByCategoryId'])->name('getAutoByCategoryId');
Route::get('autos/active',[CategoryController::class, 'getAllActive'])->name('getAllActive');
Route::post('autos/status/update',[AutomationController::class, 'automStatusUpdate'])->name('automStatusUpdate');
Route::get('blogs', [BlogController::class, 'getAllBlogs'])->name('getAllBlogs');
Route::post('blogs/search', [BlogController::class, 'searchBlog'])->name('searchBlog');
Route::get('blogs/{offset}/{limit}', [BlogController::class, 'getBlogByPage'])->name('getBlogByPage');
Route::get('blogs/{url}', [BlogController::class, 'getOneBlog'])->name('getOneBlog');
Route::get('helpCenter', [HelpCenterController::class, 'getAllHs'])->name('getAllHs');
Route::post('user/login',[LoginController::class, 'userLogin'])->name('userLogin');
Route::post('user/socialLogin',[LoginController::class, 'socialLogin'])->name('socialLogin');
Route::post('user/register', [LoginController::class, 'userRegister'])->name('userRegister');
Route::post('user/register/step2', [LoginController::class, 'userRegisterStep2'])->name('userRegisterStep2')->middleware('auth:user-api');
Route::post('subscription', [SubsribtionController::class, 'addSub'])->name('addSub');
Route::post('conactUs', [ContactUsController::class, 'addContactUs'])->name('addContactUs');
Route::post('user/passwordReset', [LoginController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('getCsv', [AutomationController::class, 'exportCsv'])->name('exportCsv');
Route::post('parseRequest', [AutomationController::class, 'parseRequest'])->name('parseRequest');
//Route::post('admin/register', [LoginController::class, 'adminRegister'])->name('adminRegister');getAutomationsStatus
Route::post('password/reset', [LoginController::class, 'passwordReset'])->name('password.reset');
Route::get('email/verify', [LoginController::class, 'verificationNotice'])->middleware('auth')->name('verification.notice');
Route::post('file/upload', [AutomationController::class, 'uploadCsv'])->name('uploadCsv');
Route::post('autos/ddb', [AutomationController::class, 'dateDiffBet'])->name('dateDiffBet');
Route::post('autos/rdbr', [AutomationController::class, 'returnDataByRow'])->name('returnDataByRow');
Route::post('autos/yellowPageCompanyExtractor', [AutomationController::class, 'yellowPageCompanyExtractor'])->name('yellowPageCompanyExtractor');
Route::post('autos/mapExtract', [AutomationController::class, 'mapExtract'])->name('mapExtract');
Route::post('autos/extractData', [AutomationController::class, 'automExtraction'])->name('automExtraction');
Route::post('autos/action', [AutomationController::class, 'automAction'])->name('automAction');

Route::post('email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return 'Verification link sent!';
})->middleware('auth:user-api')->name('verification.send');
Route::get('/email/verify/{id}/{hash}',[LoginController::class,'verify'])->name('verification.verify');
//Route::post('/email/verification-notification',[LoginController::class,'resendEmailVerify'])->middleware('auth:user-api')->name('verification.send');

Route::group( ['middleware' => ['auth:user-api','verified']],function(){ 
    Route::group(['middleware' => 'verified'], function () {
        Route::post('autos/run',[AutomationController::class, 'runAutom'])->name('runAutom')->middleware('verified');
        Route::post('autos/stop',[AutomationController::class, 'stopAutom'])->name('stopAutom')->middleware('verified');
        Route::post('autos/gftd', [AutomationController::class, 'getFullTabData'])->name('getFullTabData')->middleware('verified');
    });
    
});
Route::group( ['prefix' => 'user','middleware' => ['auth:user-api','verified'] ],function(){
   // authenticated staff routes here 
        Route::get('getAutomationsStatus',[AutomationController::class, 'getAutomationsStatus'])->middleware('verified');
        Route::post('sendFileWithEmail',[AutomationController::class, 'sendFileWithEmail'])->middleware('verified');
        Route::get('getAutomationsStatusDetails',[AutomationController::class, 'getAutomationsStatusDetails'])->middleware('verified');
        Route::get('dashboard',[LoginController::class, 'userDashboard'])->middleware('verified');
        Route::get('package', [PackageUsersController::class, 'checkPackage'])->name('checkPackage');
        Route::post('create-stripe-customer', [OrderController::class, 'createStripeCustomer'])->name('createStripeCustomer');
        Route::post('update', [LoginController::class, 'updateUser'])->name('updateUser');
        Route::post('logout', [LoginController::class, 'userLogout'])->name('logout');
        Route::group(['middleware' => 'verified'], function () {
            Route::get('/greeting', function () {
                return 'Hello World';
            })->middleware('verified');
        });
    
    
});   