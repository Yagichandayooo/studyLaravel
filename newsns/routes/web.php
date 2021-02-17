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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function() {

    // ユーザ関連
    Route::resource('users', 'App\Http\Controllers\UsersController',['only' => ['index','show', 'edit', 'update']]);

    //とうこう
    Route::resource('tweets', 'App\Http\Controllers\TweetsController', ['only' => ['index','create', 'store', 'show','update', 'destroy']]);

    //iine
    Route::resource('favorites', 'App\Http\Controllers\FavoritesController', ['only' => ['store', 'destroy']]);
});
