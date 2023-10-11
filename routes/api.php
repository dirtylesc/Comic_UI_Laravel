<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Reader\HistoryController;
use App\Http\Controllers\Reader\LibraryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::post('/check_user', [AuthController::class, 'checkUser'])->name('check_user');
Route::post('/registering', [AuthController::class, 'registering'])->name('registering');
Route::post('/check_login', [AuthController::class, 'checkLogin'])->name('check_login');

Route::group([
    'prefix' => 'users',
    'as' => 'users.',
], function () {
    Route::get('/index', [UserController::class, 'index'])->name('index');
    Route::get('/getTranslators', [UserController::class, 'getTranslators'])->name('get_translators');
    Route::post('/is_translator', [UserController::class, 'isTranslator'])->name('is_translator');
    Route::post('/add_library', [LibraryController::class, 'addToLibrary'])->name('add_library')
        ->middleware('auth');
    Route::post('/remove_library', [LibraryController::class, 'removeFromLibrary'])->name('remove_library')
        ->middleware('auth');
    Route::post('/history', [HistoryController::class, 'addToHistory'])->name('history')
        ->middleware('auth');
    Route::post('/sign_up_notification', [UserController::class, 'signUpNotification'])->name('sign_up_notification');
    Route::get('/ranking_translators', [UserController::class, 'getTranslatorsForRanking'])->name('ranking_translators');
});

Route::group([
    'prefix' => 'comics',
    'as' => 'comics.',
], function () {
    Route::get('/', [ComicController::class, 'index'])->name('index');
    Route::get('slug', [ComicController::class, 'generateSlug'])->name('generate_slug');
    Route::post('slug', [ComicController::class, 'checkSlug'])->name('check_slug');
    Route::post('/store', [ComicController::class, 'store'])->name('store');
    Route::post('/update/{id}', [ComicController::class, 'update'])->name('update');
    Route::get('/search', [ComicController::class, 'search'])->name('search');
    Route::post('status/{id}', [ComicController::class, 'changeStatus'])->name('change_status');
    Route::get('/stories', [ComicController::class, 'getComicForStories'])->name('stories');
    Route::get('/ranking_comic', [ComicController::class, 'getComicForRanking'])->name('ranking_comic');

    Route::group([
        'prefix' => '{id}/chapters',
        'as' => 'chapters.',
    ], function () {
        Route::get('/', [ChapterController::class, 'index'])->name('index');
    });
});

Route::group([
    'prefix' => 'chapters',
    'as' => 'chapters.',
], function () {
    Route::post('status/{id}', [ChapterController::class, 'approveStatus'])->name('approve_status');
    Route::post('/store', [ChapterController::class, 'store'])->name('store');
    Route::post('{id}/slug', [ChapterController::class, 'checkSlug'])->name('check_slug');
    Route::get('{id}/images', [ChapterController::class, 'getImages'])->name('get_images');
    Route::post('/update/{id}', [ChapterController::class, 'update'])->name('update');
    Route::post('/destroy/{id}', [ChapterController::class, 'destroy'])->name('destroy');
});

Route::group([
    'prefix' => 'categories',
    'as' => 'categories.',
], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
});

Route::group([
    'prefix' => 'teams',
    'as' => 'teams.',
], function () {
    Route::get('/{id}', [TeamController::class, 'show'])->name('show');
    Route::post('/store_translator', [TeamController::class, 'storeTranslator'])->name('store_translator')
        ->middleware('auth');
});

Route::group([
    'prefix' => 'comments',
    'as' => 'comments.',
], function () {
    Route::get('/{ratingId}', [CommentController::class, 'index'])->name('index');
    Route::post('/store', [CommentController::class, 'store'])->name('store');
    Route::post('/destroy/{id}', [CommentController::class, 'destroy'])->name('destroy');
    Route::post('/like/{id}', [CommentController::class, 'like'])->name('like');
    Route::post('/report/{id}', [CommentController::class, 'report'])->name('report');
});

Route::group([
    'prefix' => 'reviews',
    'as' => 'reviews.',
], function () {
    Route::get('/', [ReviewController::class, 'index'])->name('index');
    Route::post('/store', [ReviewController::class, 'store'])->name('store');
    Route::post('/destroy/{id}', [ReviewController::class, 'destroy'])->name('destroy');
    Route::post('/like/{id}', [ReviewController::class, 'like'])->name('like');
    Route::post('/report/{id}', [ReviewController::class, 'report'])->name('report');
});

Route::group([
    'prefix' => 'profiles',
    'as' => 'profiles.',
], function () {
    Route::post('/update/{id}', [UserController::class, 'update'])->name('update')
        ->middleware('checkCurrentUser');
    Route::post('/update_avatar/{id}', [UserController::class, 'updateAvatar'])->name('update_avatar')
        ->middleware('checkCurrentUser');
});

Route::group([
    'prefix' => 'languages',
    'as' => 'languages.',
], function () {
    Route::get('/', [LanguageController::class, 'index'])->name('index');
});


Route::post('/vertify_email', [AuthController::class, 'vertifyEmail'])->name('vertify_email');
