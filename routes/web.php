<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/ask-question', [QuestionController::class, 'store'])->name('ask.question');
Route::get('/feed', [FeedController::class, 'index'])->name('feed.index');
Route::get('/feed/{id}', [FeedController::class, 'show'])->name('feed.show');
Route::post('/question/{id}/delete', 'QuestionController@destroy')->middleware('auth');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');


// Cards
Route::controller(CardController::class)->group(function () {
    Route::get('/cards', 'list')->name('cards');
    Route::get('/cards/{id}', 'show');
});




// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});
