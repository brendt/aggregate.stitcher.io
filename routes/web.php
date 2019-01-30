<?php

use App\Http\Controllers\AdminSourcesController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DisclaimerController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\SourceMutesController;
use App\Http\Controllers\TagMutesController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\UserSourcesController;
use App\Http\Controllers\UserMutesController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Controllers\VotesController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\VerifiedUserMiddleware;
use Illuminate\Http\Response;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('rss', function () {
    return new Response(
        file_get_contents(storage_path('mock/rss.xml')),
        200,
        ['Content-Type' => 'application/xml']
    );
});

Route::get('/logout', [LogoutController::class, 'logout']);

Route::middleware('auth')->prefix('profile')->group(function () {

    Route::middleware(VerifiedUserMiddleware::class)->group(function () {
        Route::get('sources', [UserSourcesController::class, 'index']);
        Route::post('sources', [UserSourcesController::class, 'update']);
        Route::post('sources/delete', [UserSourcesController::class, 'delete']);
    });

    Route::post('posts/{post}/add-vote', [VotesController::class, 'store']);
    Route::post('posts/{post}/remove-vote', [VotesController::class, 'delete']);

    Route::post('sources/{source}/mute', [SourceMutesController::class, 'store']);
    Route::post('sources/{source}/unmute', [SourceMutesController::class, 'delete']);

    Route::post('tags/{tag}/mute', [TagMutesController::class, 'store']);
    Route::post('tags/{tag}/unmute', [TagMutesController::class, 'delete']);

    Route::get('mutes', [UserMutesController::class, 'index']);

    Route::post('verification/resend', [UserVerificationController::class, 'resend']);
    Route::get('verify/{verificationToken}', [UserVerificationController::class, 'verify']);
});

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('sources', [AdminSourcesController::class, 'index']);
    Route::post('sources/{source}/activate', [AdminSourcesController::class, 'activate']);
    Route::post('sources', [AdminSourcesController::class, 'store']);
});

Route::get('/', [PostsController::class, 'index']);
Route::get('latest', [PostsController::class, 'latest']);
Route::get('top', [PostsController::class, 'top']);
Route::get('/topic/{topic}', [PostsController::class, 'topic']);
Route::get('/tag/{tag}', [PostsController::class, 'tag']);
Route::get('/source/{sourceByWebsite}', [PostsController::class, 'source']);
Route::get('/privacy', PrivacyController::class);

Route::get('topics', [TopicsController::class, 'index']);

Route::get('{post}', [PostsController::class, 'show']);
