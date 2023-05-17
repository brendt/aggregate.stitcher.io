<?php

use App\Http\Controllers\AdminInfoController;
use App\Http\Controllers\Auth\RedditOAuthController;
use App\Http\Controllers\Auth\RedditOAuthRedirectController;
use App\Http\Controllers\Auth\RedditOAuthStatusController;
use App\Http\Controllers\Auth\TwitterOAuthController;
use App\Http\Controllers\Auth\TwitterOAuthRedirectController;
use App\Http\Controllers\Auth\TwitterOAuthStatusController;
use App\Http\Controllers\LatestMailController;
use App\Http\Controllers\Posts\DeletePostCommentController;
use App\Http\Controllers\Posts\FindPostController;
use App\Http\Controllers\Posts\HidePostController;
use App\Http\Controllers\Links\AdminLinksController;
use App\Http\Controllers\Links\CreateLinkController;
use App\Http\Controllers\Links\StoreLinkController;
use App\Http\Controllers\Links\VisitLinkController;
use App\Http\Controllers\Posts\AdminPostsController;
use App\Http\Controllers\Posts\PermanentlyHidePostController;
use App\Http\Controllers\Posts\PostCommentsController;
use App\Http\Controllers\Posts\StorePostCommentController;
use App\Http\Controllers\Posts\TopPostController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\Tweets\CreateMuteController;
use App\Http\Controllers\Posts\CreatePostController;
use App\Http\Controllers\Posts\DenyPendingPostsController;
use App\Http\Controllers\Tweets\RejectedTweetController;
use App\Http\Controllers\Tweets\SavedTweetController;
use App\Http\Controllers\Tweets\SaveTweetController;
use App\Http\Controllers\Tweets\StoreMuteController;
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
use App\Http\Controllers\Tweets\TweetPostController;
use App\Http\Controllers\Users\AcceptInvitationController;
use App\Http\Controllers\Users\BanUserController;
use App\Http\Controllers\Users\SendUserInvitationController;
use App\Http\Controllers\Users\SendInviteController;
use App\Http\Controllers\Users\StoreAcceptedInvitationController;
use App\Http\Controllers\Users\AboutInvitesController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Services\OAuth\Token;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
Route::get('/about-invites', AboutInvitesController::class);
Route::get('/latest-mail', LatestMailController::class);
Route::get('/tweets', TweetController::class);
Route::get('/top', TopPostController::class);
Route::get('/suggest', SuggestSourceController::class);
Route::post('/suggest', StoreSourceSuggestionController::class);
Route::get('/post/{post}/comments', PostCommentsController::class);
Route::post('/post/{post}/comments', StorePostCommentController::class);
Route::get('/post/{post}', ShowPostController::class);
Route::view('/about', 'about');
Route::get('/links/{link}', VisitLinkController::class);

Route::get('/invite/accept/{code}', AcceptInvitationController::class);
Route::post('/invite/accept/{code}', StoreAcceptedInvitationController::class);

Route::middleware(['auth'])
    ->prefix('/user')
    ->group(function () {
        Route::get('/invite', SendInviteController::class);
        Route::post('/invite', SendUserInvitationController::class);
    });

Route::middleware(['auth', IsAdminMiddleware::class])
    ->prefix('/admin')
    ->group(function () {
        Route::get('/reddit/auth', RedditOAuthController::class);
        Route::get('/reddit/redirect', RedditOAuthRedirectController::class);
        Route::get('/reddit/status', RedditOAuthStatusController::class);

        Route::get('/twitter/auth', TwitterOAuthController::class);
        Route::get('/twitter/redirect', TwitterOAuthRedirectController::class);
        Route::get('/twitter/status', TwitterOAuthStatusController::class);

        Route::get('/find', FindPostController::class);
        Route::get('/info', AdminInfoController::class);
        Route::get('/stats', StatsController::class);
        Route::get('/posts', AdminPostsController::class);
        Route::get('/posts/create', CreatePostController::class);
        Route::post('/posts/create', StorePostController::class);
        Route::get('/posts/deny-all', DenyPendingPostsController::class);
        Route::get('/posts/deny/{post}', DenyPostController::class);
        Route::post('/posts/deny/{post}', DenyPostController::class);
        Route::get('/posts/publish/{post}', PublishPostController::class);
        Route::post('/posts/publish/{post}', PublishPostController::class);
        Route::get('/posts/star/{post}', StarPostController::class);
        Route::get('/posts/tweet/{post}', TweetPostController::class);
        Route::get('/posts/hide/{post}', HidePostController::class);
        Route::get('/posts/hide-permanently/{post}', PermanentlyHidePostController::class);
        Route::get('/posts/comments/{postComment}/delete', DeletePostCommentController::class);

        Route::get('/mutes/create', CreateMuteController::class);
        Route::post('/mutes/create', StoreMuteController::class);

        Route::get('/tweets', AdminTweetController::class);
        Route::get('/tweets/rejected', RejectedTweetController::class);
        Route::get('/tweets/saved', SavedTweetController::class);
        Route::get('/tweets/deny-all', DenyPendingTweetsController::class);
        Route::post('/tweets/save/{tweet}', SaveTweetController::class);
        Route::post('/tweets/deny/{tweet}', DenyTweetController::class);
        Route::get('/tweets/save/{tweet}', SaveTweetController::class);
        Route::get('/tweets/deny/{tweet}', DenyTweetController::class);
        Route::get('/tweets/publish/{tweet}', PublishTweetController::class);

        Route::get('/sources', AdminSourcesController::class);
        Route::get('/sources/{source}', AdminSourceDetailController::class);
        Route::get('/sources/deny/{source}', DenySourceController::class);
        Route::get('/sources/publish/{source}', PublishSourceController::class);
        Route::get('/sources/delete/{source}', DeleteSourceController::class);

        Route::get('/links', AdminLinksController::class);
        Route::get('/links/create', CreateLinkController::class);
        Route::post('/links/create', StoreLinkController::class);

        Route::get('/users/{user}/ban', BanUserController::class);
    });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', IsAdminMiddleware::class])->name('dashboard');

Route::mailPreview();

Route::feeds();

require __DIR__ . '/auth.php';
