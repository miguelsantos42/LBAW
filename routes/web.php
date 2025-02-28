<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;


// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/ask-question', [QuestionController::class, 'store'])->name('ask.question');
Route::get('/feed', [FeedController::class, 'index'])->name('feed.index');
Route::get('/feed/{id}', [FeedController::class, 'show'])->name('feed.show');
Route::post('/question/{id}/delete', 'QuestionController@destroy')->middleware('auth');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/{comment}/upvote', [CommentController::class, 'upvoteComment'])->name('comments.upvote');
Route::post('/comments/{comment}/downvote', [CommentController::class, 'downvoteComment'])->name('comments.downvote');
Route::post('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/profile/delete', [ProfileController::class, 'delete'])->name('profile.delete');
Route::get('/questions/create', [QuestionController::class, 'create'])->name('ask.create');
Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
Route::post('/comments/{comment}/mark-as-correct', [CommentController::class, 'markAsCorrect'])->name('comments.markAsCorrect');


Route::get('/tags/search', [TagController::class, 'search'])->name('tags.search');
Route::get('/tags/create', [TagController::class, 'create'])->name('tags.create');
Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');
Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
Route::resource('tags', TagController::class)->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);

Route::post('/tags/{tag}/follow', [TagController::class, 'follow'])->name('tags.follow');
Route::post('/tags/{tag}/unfollow', [TagController::class, 'unfollow'])->name('tags.unfollow');

Route::post('/question/{question}/follow', [QuestionController::class, 'follow'])->name('questions.follow');
Route::post('/question/{question}/unfollow', [QuestionController::class, 'unfollow'])->name('questions.unfollow');


Route::post('/questions/{question}/upvote', [CommentController::class, 'upvoteQuestion'])->name('questions.upvote');
Route::post('/questions/{question}/downvote', [CommentController::class, 'downvoteQuestion'])->name('questions.downvote');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

Route::post('/questions/{question}/upvote', [QuestionController::class, 'upvoteQuestion'])->name('questions.upvote');
Route::post('/questions/{question}/downvote', [QuestionController::class, 'downvoteQuestion'])->name('questions.downvote');



Route::middleware(['checkRole:1'])->group(function () {
    Route::get('/moderator', [AdminController::class, 'index'])->name('moderator');
    Route::post('/moderator/users', [AdminController::class, 'storeUser'])->name('moderator.store-user');
    // Add other moderator routes as needed
});

Route::middleware(['checkRole:2'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.store-user');
    // Add other admin routes as needed
});

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


// Delete an user (ONLY) -> Do it by an Admin
Route::delete('/admin/user/{id}/delete', [AdminController::class, 'destroy'])->name('admin.destroy');


Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

//Admin block or unblock some user

Route::post('/admin/users/{id}/block', [AdminController::class,'blockUser'])->name('admin.blockuser');
Route::post('/admin/users/{id}/unblock', [AdminController::class,'unblockUser'])->name('admin.unblockuser');



//mail

Route::post('/send', [MailController::class, 'send']);
Route::get('/send-mail', [UserController::class, 'showLinkRequestForm'])->name('send-mail');
Route::get('/password/reset', [UserController::class, 'showUpdatePassForm'])->name('password.reset');
Route::post('/password/reset', [UserController::class, 'updatePassword'])->name('password.update');