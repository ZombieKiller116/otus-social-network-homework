<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/profiles/show/{id?}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profiles.show');
Route::get('/profiles/list', [App\Http\Controllers\ProfileController::class, 'list'])->name('profiles.list');

Route::get('/friends', [App\Http\Controllers\FriendController::class, 'index'])->name('friends.index');
Route::get('/friends/add{id}', [App\Http\Controllers\FriendController::class, 'add'])->name('friends.add');
Route::get('/friends/remove{id}', [App\Http\Controllers\FriendController::class, 'remove'])->name('friends.remove');


