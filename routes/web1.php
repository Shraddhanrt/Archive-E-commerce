<?php

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

Route::get('/demo', [App\Http\Controllers\SiteController::class, 'getHome'])->name('getHome');
Route::get('/story', [App\Http\Controllers\SiteController::class, 'getStory'])->name('getStory');
Route::get('/product/{slug}', [App\Http\Controllers\SiteController::class, 'getProductDetail'])->name('getProductDetail');
Route::post('/cart', [App\Http\Controllers\SiteController::class, 'postAddToCart'])->name('postAddToCart');
Route::get('/carts', [App\Http\Controllers\SiteController::class, 'getCart'])->name('getCart');
Route::get('/checkout', [App\Http\Controllers\SiteController::class, 'postCheckOut'])->name('postCheckOut');
Route::get('/cart/delete/{cart}', [App\Http\Controllers\SiteController::class, 'getDeleteCart'])->name('getDeleteCart');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

