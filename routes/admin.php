<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ComicController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\RankingController;
use App\Http\Controllers\Admin\TeamController;
use Illuminate\Support\Facades\Route;

// Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('superadmin')->get('/', [UserController::class, 'index'])->name('index');
Route::group([
    'middleware' => 'superadmin',
    'prefix' => 'users',
    'as' => 'users.',
], function () {
    Route::get('show/{id}', [UserController::class, 'show'])->name('show');
    Route::post('destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
});

Route::group([
    'prefix' => 'comics',
    'as' => 'comics.',
], function () {
    Route::get('/', [ComicController::class, 'index'])->name('index');
    Route::get('/create', [ComicController::class, 'create'])->name('create');
    Route::post('show/{slug}', [ComicController::class, 'show'])->name('show');
    Route::get('edit/{id}', [ComicController::class, 'edit'])->name('edit');
    Route::post('destroy/{id}', [ComicController::class, 'destroy'])->name('destroy');
});

Route::group([
    'prefix' => 'comics/{slug}',
    'as' => 'comics.',
], function () {
    Route::group([
        'prefix' => 'chapters',
        'as' => 'chapters.',
    ], function () {
        Route::get('/', [ChapterController::class, 'index'])->name('index');
        Route::get('/images', [ChapterController::class, 'previewChapter'])->name('preview_chapter');
    });
});

Route::group([
    'prefix' => 'chapters',
    'as' => 'chapters.',
], function () {
    Route::get('/images', [ChapterController::class, 'previewChapter'])->name('preview_chapter');
});

Route::group([
    'prefix' => 'teams',
    'as' => 'teams.',
], function () {
    Route::get('/', [TeamController::class, 'index'])->name('index');
    Route::get('/{id}', [TeamController::class, 'show'])->name('show');
    Route::get('/destroy/{id}', [TeamController::class, 'destroy'])->name('destroy');
});

Route::group([
    'prefix' => 'ranking',
    'as' => 'ranking.',
], function () {
    Route::get('/', [RankingController::class, 'index'])->name('index');
});
