<?php

use App\Http\Controllers\DenyPostController;
use App\Http\Controllers\DenySourceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublishPostController;
use App\Http\Controllers\PublishSourceController;
use App\Http\Controllers\SourcesAdminController;
use App\Http\Controllers\StarPostController;
use App\Http\Controllers\StoreSourceSuggestionController;
use App\Http\Controllers\SuggestSourceController;
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

Route::middleware(['auth'])->group(function () {
   Route::get('/post/deny/{post}', DenyPostController::class);
   Route::get('/post/publish/{post}', PublishPostController::class);
   Route::get('/post/star/{post}', StarPostController::class);

    Route::get('/sources', SourcesAdminController::class);
    Route::get('/source/deny/{source}', DenySourceController::class);
    Route::get('/source/publish/{source}', PublishSourceController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::mailPreview();

require __DIR__ . '/auth.php';
