<?php

use App\Http\Controllers\Posts\AdminPostsController;
use App\Http\Controllers\Posts\DenyPendingPostsController;
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
Route::get('/suggest', SuggestSourceController::class);
Route::post('/suggest', StoreSourceSuggestionController::class);
Route::get('/post/{post}', ShowPostController::class);

Route::middleware(['auth'])->group(function () {
   Route::get('/posts', AdminPostsController::class);
   Route::get('/posts/deny-all', DenyPendingPostsController::class);
   Route::get('/post/deny/{post}', DenyPostController::class);
   Route::get('/post/publish/{post}', PublishPostController::class);
   Route::get('/post/star/{post}', StarPostController::class);

    Route::get('/sources', AdminSourcesController::class);
    Route::get('/source/deny/{source}', DenySourceController::class);
    Route::get('/source/publish/{source}', PublishSourceController::class);
    Route::get('/source/delete/{source}', DeleteSourceController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::mailPreview();

Route::feeds();

require __DIR__ . '/auth.php';
