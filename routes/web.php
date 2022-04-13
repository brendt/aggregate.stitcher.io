<?php

use App\Http\Controllers\DenyPostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublishPostController;
use App\Http\Controllers\StarPostController;
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

Route::middleware(['auth'])->group(function () {
   Route::get('/deny/{post}', DenyPostController::class);
   Route::get('/publish/{post}', PublishPostController::class);
   Route::get('/star/{post}', StarPostController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
