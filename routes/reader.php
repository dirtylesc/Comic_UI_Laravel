<?php

use App\Http\Controllers\Reader\HistoryController;
use App\Http\Controllers\Reader\LibraryController;
use App\Http\Controllers\Reader\CategoryController;
use App\Http\Controllers\Reader\ChapterController;
use App\Http\Controllers\Reader\ComicController;
use App\Http\Controllers\Reader\HomeController;
use App\Http\Controllers\Reader\UserController;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('index')->middleware(Localization::class);
Route::get('/stories', [HomeController::class, 'stories'])->name('stories');
Route::get('/ranking', [HomeController::class, 'ranking'])->name('ranking');
Route::get('/library', [LibraryController::class, 'library'])->name('library')
    ->middleware('auth');
Route::get('/history', [HistoryController::class, 'index'])->name('history')
    ->middleware('auth');

Route::group([
    'prefix' => 'comics/{slug}',
    'as' => 'comics.',
], function () {
    Route::get('/', [ComicController::class, 'index'])->name('index');
    Route::get('/{chapterSlug}', [ChapterController::class, 'index'])->name('show_chapter');
});

Route::group([
    'prefix' => 'tags',
    'as' => 'tags.',
], function () {
    Route::get('/{slug}', [CategoryController::class, 'index'])->name('index');
});

Route::group([
    'prefix' => 'profiles',
    'as' => 'profiles.',
], function () {
    Route::get('/{id}', [UserController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit')
        ->middleware('checkCurrentUser');
});
