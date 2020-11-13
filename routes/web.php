<?php

use App\Admin\Controllers\AdminAnalyticsController;
use App\Admin\Controllers\AdminErrorLogController;
use App\Admin\Controllers\AdminSourcesController;
use App\Admin\Controllers\AdminTagsController;
use App\Admin\Controllers\AdminTopicsController;
use App\Admin\Middleware\AdminStatusMiddleware;
use App\Feed\Controllers\SourceReportsController;
use App\User\Controllers\ForgotPasswordController;
use App\User\Controllers\LoginController;
use App\User\Controllers\RegisterController;
use App\User\Controllers\ResetPasswordController;
use App\User\Controllers\GuestSourcesController;
use App\Feed\Controllers\PostsController;
use App\Feed\Controllers\PostTweetController;
use App\Feed\Controllers\SourceMutesController;
use App\User\Controllers\TagMutesController;
use App\Feed\Controllers\TopicsController;
use App\User\Controllers\UserInterestsController;
use App\User\Controllers\UserProfileController;
use App\User\Controllers\UserSourcesController;
use App\User\Controllers\UserMutesController;
use App\User\Controllers\UserVerificationController;
use App\Admin\Middleware\AdminMiddleware;
use App\User\Middleware\VerifiedUserMiddleware;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::feeds();

Route::middleware('auth')->prefix('profile')->group(function () {

    Route::middleware(VerifiedUserMiddleware::class)->group(function () {
        Route::get('sources', [UserSourcesController::class, 'index']);
        Route::post('sources', [UserSourcesController::class, 'update']);
        Route::get('sources/delete', [UserSourcesController::class, 'confirmDelete']);
        Route::post('sources/delete', [UserSourcesController::class, 'delete']);

        Route::get('interests', [UserInterestsController::class, 'index']);
        Route::post('interests', [UserInterestsController::class, 'update']);

        Route::get('edit', [UserProfileController::class, 'index']);
        Route::post('edit/password', [UserProfileController::class, 'updatePassword']);
        Route::post('edit/languages', [UserProfileController::class, 'addLanguage']);
        Route::get('edit/languages/remove', [UserProfileController::class, 'removeLanguage']);
    });

    Route::post('sources/{source}/mute', [SourceMutesController::class, 'store']);
    Route::post('sources/{source}/unmute', [SourceMutesController::class, 'delete']);

    Route::post('sources/{source}/report', [SourceReportsController::class, 'store']);


    Route::post('tags/{tag}/mute', [TagMutesController::class, 'store']);
    Route::post('tags/{tag}/unmute', [TagMutesController::class, 'delete']);

    Route::get('mutes', [UserMutesController::class, 'index']);

    Route::post('verification/resend', [UserVerificationController::class, 'resend']);
    Route::get('verify/{verificationToken}', [UserVerificationController::class, 'verify']);
});

Route::middleware([
    'auth',
    AdminMiddleware::class,
    AdminStatusMiddleware::class,
])->prefix('admin')->group(function () {
    Route::get('/analytics', [AdminAnalyticsController::class, 'index']);
    Route::get('/analytics/page-cache', [AdminAnalyticsController::class, 'pageCache']);

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

    Route::post('posts/{post}/tweet', PostTweetController::class);
});

Route::get('suggest-blog', [GuestSourcesController::class, 'index']);
Route::post('suggest-blog', [GuestSourcesController::class, 'store']);

Route::get('topics', [TopicsController::class, 'index']);

Route::get('{post}', [PostsController::class, 'show']);
