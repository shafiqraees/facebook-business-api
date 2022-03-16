<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GraphController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

/*Route::middleware('auth')->group(function () {*/
    Route::resource('post', PostController::class);
    Route::post('/getall', [PostController::class, 'getall'])->name('getall');
    Route::post('/getmodal', [PostController::class, 'getmodal'])->name('getmodal');

    Route::resource('profile', ProfileController::class);
    Route::any('/facebook', [ProfileController::class, 'loginUsingFacebook'])->name('facebook');
    //Route::any('/facebook/login', [ProfileController::class, 'handleProviderFacebookCallback'])->name('facebook');
    Route::any('/facebook/callback', [ProfileController::class, 'callBack'])->name('callback');
    Route::any('/facebook_page_id', [ProfileController::class, 'facebook_page_id'])->name('facebook_page_id');
    Route::any('page', [GraphController::class, 'publishToPage'])->name('page');
/*});*/
