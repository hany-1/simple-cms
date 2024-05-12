<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;

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

Auth::routes();
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/test', [HomeController::class, 'test'])->name('test');
    //Posts
    Route::resource('posts', PostController::class);
    //Pages
    Route::resource('pages', PageController::class);
    //Users
    Route::resource('users', UserController::class);

    //Category
    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get('/', [TermController::class, 'index'])->name('index');
        Route::get('/create', [TermController::class, 'create'])->name('create');
        Route::get('/{category}/edit', [TermController::class, 'edit'])->name('edit');
        Route::post('/store', [TermController::class, 'store'])->name('store');
        Route::put('/{category}', [TermController::class, 'update'])->name('update');
        Route::delete('/{category}', [TermController::class, 'destroy'])->name('destroy');
    });
    //Tag
    Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
        Route::get('/', [TermController::class, 'index'])->name('index');
        Route::get('/create', [TermController::class, 'create'])->name('create');
        Route::get('/{tag}/edit', [TermController::class, 'edit'])->name('edit');
        Route::post('/store', [TermController::class, 'store'])->name('store');
        Route::put('/{tag}', [TermController::class, 'update'])->name('update');
        Route::delete('/{tag}', [TermController::class, 'destroy'])->name('destroy');
    });
});
