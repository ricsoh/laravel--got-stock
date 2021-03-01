<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Static page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about_us', function () {
    return view('about_us');
});

// Authentication controller
Auth::routes();

// Home controller
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::post('/home', [App\Http\Controllers\HomeController::class, 'postCreate'])->name('home.postCreate'); // => ME, for admin editing user role
Route::post('/home', [App\Http\Controllers\HomeController::class, 'postEdit'])->name('home.postEdit'); // => ME, for admin editing user role
Route::post('/home/destroy', [App\Http\Controllers\HomeController::class, 'destroy'])->name('home.destroy'); // => ME, for admin deleting user

// Profile controller
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::get('/profile/create', [App\Http\Controllers\ProfileController::class, 'create']);
Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'postCreate'])->name('profile.postCreate'); // => ME, for creating new user profile table
Route::post('/profile/postEdit', [App\Http\Controllers\ProfileController::class, 'postEdit'])->name('profile.postEdit'); // => ME, for editing user profile table
//Route::post('/profile/{id}/update', [App\Http\Controllers\ProfileController::class, 'postEdit'])->name('profile.postEdit');

// Post controller
Route::resource('post', App\Http\Controllers\PostController::class);

// Category controller
Route::resource('category', App\Http\Controllers\CategoryController::class);
