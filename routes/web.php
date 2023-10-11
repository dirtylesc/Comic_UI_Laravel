<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/', function () {
    print_r(123);
    return redirect()->route('reader.index');
});

Route::get('test', [TestController::class, 'test'])->name('test');

Route::get('error_404', function () {
    return view('clients.error404');
})->name('error_404');

Route::get('/language/{locale}', function ($locale) {
    if (!in_array($locale, config('app.locales'))) {
        $locale = config('app.fallback_locale');
    }

    session()->put('locale', $locale);

    return redirect()->back()->withCookie(cookie('locale', $locale, 60 * 24 * 30));
})->name('language');

Route::get('/linkstorage', function () {
    echo 123;
    Artisan::call('storage:link');
});
