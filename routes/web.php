<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AutomationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackageUsersController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return redirect()->route('index');
})->name('/');

//Language Change
Route::get('lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'de', 'es','fr','pt', 'cn', 'ae'])) {
        abort(400);
    }   
    Session()->put('locale', $locale);
    Session::get('locale');
    return redirect()->back();
})->name('lang');
    


Route::view('login','login.login')->name('login');

Route::prefix('others')->group(function () {
    Route::view('400', 'errors.400')->name('error-400');
    Route::view('401', 'errors.401')->name('error-401');
    Route::view('403', 'errors.403')->name('error-403');
    Route::view('404', 'errors.404')->name('error-404');
    Route::view('500', 'errors.500')->name('error-500');
    Route::view('503', 'errors.503')->name('error-503');
});

Route::post('admin/login',[LoginController::class, 'adminLoginNext'])->name('adminLoginNext');
Route::get('admin/logout',[LoginController::class, 'adminLogOut'])->name('adminLogOut');

Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function()
{
    Route::prefix('dashboard')->group(function () {
        Route::view('index', 'dashboard.index')->name('index');
        Route::view('dashboard-02', 'dashboard.dashboard-02')->name('dashboard-02');
    });
    
        Route::prefix('manage')->group(function (){
            Route::get('list',[AdminController::class, 'listAll'])->middleware('userType');
            Route::get('edit/{id}',[AdminController::class, 'editAdmin'])->middleware('userType');
            Route::put('edit/{id}',[AdminController::class, 'updateAdmin'])->middleware('userType');
            Route::delete('delete/{id}',[AdminController::class, 'deleteAdmin'])->middleware('userType');
            Route::view('add','admin.form')->middleware('userType');
            Route::post('add',[AdminController::class, 'addAdmin'])->middleware('userType');
        });
        Route::prefix('category')->group(function (){
            Route::get('list',[CategoryController::class, 'listAll'])->middleware('userType');
            Route::get('edit/{id}',[CategoryController::class, 'editCat'])->middleware('userType');
            Route::put('edit/{id}',[CategoryController::class, 'updateCat'])->middleware('userType');
            Route::delete('delete/{id}',[CategoryController::class, 'deleteCat'])->middleware('userType');
            Route::get('add',[CategoryController::class, 'addCatView'])->middleware('userType');
            Route::post('add',[CategoryController::class, 'addCat'])->middleware('userType');
        });
        Route::prefix('automation')->group(function () {
            Route::get('list',[AutomationController::class, 'listAllAutos'])->middleware('userType');
            Route::post('add',[AutomationController::class, 'addAuto'])->middleware('userType');
            Route::get('add',[AutomationController::class, 'addAutoView'])->middleware('userType');
            //Route::view('test','automation.test')->name('test');
            Route::get('edit/{id}',[AutomationController::class, 'editAuto'])->middleware('userType');
            Route::put('edit/{id}',[AutomationController::class, 'updateAuto'])->middleware('userType');
            Route::delete('delete/{id}',[AutomationController::class, 'deleteAuto'])->middleware('userType');
            Route::post('ckeditor/upload', '\App\Http\Controllers\CKEditorController@upload')->name('ckeditor.image-upload')->middleware('userType');
        });

    
    

    Route::prefix('type')->group(function (){
        Route::get('list',[TypeController::class, 'listAll'])->middleware('userType');
        Route::get('edit/{id}',[TypeController::class, 'editType'])->middleware('userType');
        Route::put('edit/{id}',[TypeController::class, 'updateType'])->middleware('userType');
        Route::delete('delete/{id}',[TypeController::class, 'deleteType'])->middleware('userType');
        Route::view('add','type.form')->middleware('userType');
        Route::post('add',[TypeController::class,'addType'])->middleware('userType');
    });

    Route::prefix('helpCenter')->group(function (){
        Route::get('list',[HelpCenterController::class, 'listAll']);
        Route::get('edit/{id}',[HelpCenterController::class, 'editHs']);
        Route::put('edit/{id}',[HelpCenterController::class, 'updateHs']);
        Route::delete('delete/{id}',[HelpCenterController::class, 'deleteHs']);
        Route::view('add','helpcenter.form');
        Route::post('add',[HelpCenterController::class,'addHs']);
    });

    Route::prefix('blog')->group(function () {
        Route::get('list', [BlogController::class, 'listAll']);
        Route::get('edit/{id}', [BlogController::class, 'editBlog']);
        Route::put('edit/{id}', [BlogController::class, 'updateBlog']);
        Route::delete('delete/{id}', [BlogController::class, 'deleteBlog']);
        Route::get('add', [BlogController::class, 'addBlogView']);
        Route::post('add',[BlogController::class, 'addBlog']);
    });

    Route::prefix('tag')->group(function (){
        Route::get('list',[TagController::class, 'listAll']);
        Route::get('edit/{id}',[TagController::class, 'editTag']);
        Route::put('edit/{id}',[TagController::class, 'updateTag']);
        Route::delete('delete/{id}',[TagController::class, 'deleteTag']);
        Route::view('add','tag.form');
        Route::post('add',[TagController::class,'addTag']);
    });

    Route::prefix('package')->group(function (){
        Route::get('list',[PackageController::class, 'listAll'])->middleware('userType');
        Route::get('user',[PackageUsersController::class, 'listAll'])->middleware('userType');
        Route::get('edit/{id}',[PackageController::class, 'editPackage'])->middleware('userType');
        Route::put('edit/{id}',[PackageController::class, 'updatePackage'])->middleware('userType');
        Route::delete('delete/{id}',[PackageController::class, 'deletePackage'])->middleware('userType');
        Route::view('add','package.form')->middleware('userType');
        Route::post('add',[PackageController::class,'addPackage'])->middleware('userType');
    });
});

Route::any('stripe/webhook', [StripeWebhookController::class, 'handle']);