<?php

use App\Http\Controllers\Posts\AdminPostsController;
use App\Http\Controllers\Posts\CreateMuteController;
use App\Http\Controllers\Posts\CreatePostController;
use App\Http\Controllers\Posts\DenyPendingPostsController;
use App\Http\Controllers\Posts\StoreMuteController;
use App\Http\Controllers\Posts\StorePostController;
use App\Http\Controllers\Sources\AdminSourceDetailController;
use App\Http\Controllers\Sources\DeleteSourceController;
use App\Http\Controllers\Posts\DenyPostController;
use App\Http\Controllers\Sources\DenySourceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Posts\PublishPostController;
use App\Http\Controllers\Sources\PublishSourceController;
use App\Http\Controllers\Posts\ShowPostController;
use App\Http\Controllers\Sources\AdminSourcesController;
use App\Http\Controllers\Posts\StarPostController;
use App\Http\Controllers\Sources\StoreSourceSuggestionController;
use App\Http\Controllers\Sources\SuggestSourceController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\Tweets\AdminTweetController;
use App\Http\Controllers\Tweets\DenyPendingTweetsController;
use App\Http\Controllers\Tweets\DenyTweetController;
use App\Http\Controllers\Tweets\PublishTweetController;
use App\Http\Controllers\Tweets\TweetController;
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

Route::get('/', HomeController::class);
Route::get('/tweets', TweetController::class);
Route::get('/top', TopController::class);
Route::get('/suggest', SuggestSourceController::class);
Route::post('/suggest', StoreSourceSuggestionController::class);
Route::get('/post/{post}', ShowPostController::class);
Route::view('/about', 'about');

Route::middleware(['auth'])
    ->prefix('/admin')
    ->group(function () {
        Route::get('/posts', AdminPostsController::class);
        Route::get('/posts/create', CreatePostController::class);
        Route::post('/posts/create', StorePostController::class);
        Route::get('/posts/deny-all', DenyPendingPostsController::class);
        Route::get('/posts/deny/{post}', DenyPostController::class);
        Route::get('/posts/publish/{post}', PublishPostController::class);
        Route::get('/posts/star/{post}', StarPostController::class);

        Route::get('/mutes/create', CreateMuteController::class);
        Route::post('/mutes/create', StoreMuteController::class);

        Route::get('/tweets', AdminTweetController::class);
        Route::get('/tweets/deny-all', DenyPendingTweetsController::class);
        Route::get('/tweets/deny/{tweet}', DenyTweetController::class);
        Route::get('/tweets/publish/{tweet}', PublishTweetController::class);

        Route::get('/sources', AdminSourcesController::class);
        Route::get('/sources/{source}', AdminSourceDetailController::class);
        Route::get('/sources/deny/{source}', DenySourceController::class);
        Route::get('/sources/publish/{source}', PublishSourceController::class);
        Route::get('/sources/delete/{source}', DeleteSourceController::class);
    });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::mailPreview();

Route::feeds();

require __DIR__ . '/auth.php';
