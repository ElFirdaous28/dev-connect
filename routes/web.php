<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserProgrammingLanguageController;
use App\Http\Controllers\UserSkillController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PostController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', ProjectController::class);
    Route::resource('certificates', CertificateController::class);
    Route::resource('programming-languages', UserProgrammingLanguageController::class);
    Route::resource('skills', UserSkillController::class);


    // connection toutes
    Route::get('/connections', function () {
        return view('my-connections');
    })->name('connections.list');
    
    Route::post('/connect/{user}', [ConnectionController::class, 'connect'])->name('connect');
    Route::post('/connection/{connectionId}/accept', [ConnectionController::class, 'accept']);
    Route::post('/connection/{connectionId}/reject', [ConnectionController::class, 'reject']);
    Route::post('/connection/{connectionId}/delete', [ConnectionController::class, 'delete']);


    // posts
    Route::resource('posts', PostController::class);

    // likes
    Route::post('/posts/{post}/like', [LikeController::class, 'toggleLike'])->name('posts.like');
    Route::get('/posts/{post}/check-like', [LikeController::class, 'checkLike'])->name('posts.checkLike');


    // comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // messages
    Route::get('/chat/{user}', [MessageController::class, 'chat'])->name('chat');
    Route::post('/chat/send', [MessageController::class, 'sendMessage'])->name('chat.send');

    Route::get('/search', [SearchController::class, 'search'])->name('search');
});

require __DIR__ . '/auth.php';
