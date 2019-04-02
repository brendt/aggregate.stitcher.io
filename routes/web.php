<?php

use App\Http\Controllers\AdminAnalyticsController;
use App\Http\Controllers\AdminErrorLogController;
use App\Http\Controllers\AdminSourcesController;
use App\Http\Controllers\AdminTagsController;
use App\Http\Controllers\AdminTopicsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\GuestSourcesController;
use App\Http\Controllers\PostsController;
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
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
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

Route::middleware('auth')->prefix('profile')->group(function () {

    Route::middleware(VerifiedUserMiddleware::class)->group(function () {
        Route::get('sources', [UserSourcesController::class, 'index']);
        Route::post('sources', [UserSourcesController::class, 'update']);
        Route::get('sources/delete', [UserSourcesController::class, 'confirmDelete']);
        Route::post('sources/delete', [UserSourcesController::class, 'delete']);

        Route::get('profile', [\App\Http\Controllers\UserProfileController::class, 'index']);
        Route::post('profile', [\App\Http\Controllers\UserProfileController::class, 'update']);
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
    Route::get('/analytics', [AdminAnalyticsController::class, 'index']);

    Route::get('/error-log/{type}/{id}', [AdminErrorLogController::class, 'index']);

    Route::prefix('sources')->group(function () {
        Route::get('/', [AdminSourcesController::class, 'index']);
        Route::get('/{source}', [AdminSourcesController::class, 'edit']);
        Route::get('/{source}/delete', [AdminSourcesController::class, 'confirmDelete']);

        Route::post('/{source}', [AdminSourcesController::class, 'update']);
        Route::post('/{source}/activate', [AdminSourcesController::class, 'activate']);
        Route::post('/{source}/sync', [AdminSourcesController::class, 'sync']);
        Route::post('/{source}/delete', [AdminSourcesController::class, 'delete']);

        Route::post('/', [AdminSourcesController::class, 'store']);
    });

    Route::prefix('tags')->group(function () {
        Route::get('/', [AdminTagsController::class, 'index']);

        Route::get('/new', [AdminTagsController::class, 'create']);
        Route::post('/', [AdminTagsController::class, 'store']);

        Route::get('/{tag}', [AdminTagsController::class, 'edit']);
        Route::post('/{tag}', [AdminTagsController::class, 'update']);
    });

    Route::prefix('topics')->group(function () {
        Route::get('/', [AdminTopicsController::class, 'index']);

        Route::get('/new', [AdminTopicsController::class, 'create']);
        Route::post('/', [AdminTopicsController::class, 'store']);

        Route::get('/{topic}', [AdminTopicsController::class, 'edit']);
        Route::post('/{topic}', [AdminTopicsController::class, 'update']);
    });

    Route::post('posts/{post}/tweet', \App\Http\Controllers\PostTweetController::class);
});

Route::get('suggest-blog', [GuestSourcesController::class, 'index']);
Route::post('suggest-blog', [GuestSourcesController::class, 'store']);

Route::get('topics', [TopicsController::class, 'index']);

Route::get('{post}', [PostsController::class, 'show']);
