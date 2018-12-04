<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\SourcesController;
use App\Http\Controllers\VotesController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/logout', [LogoutController::class, 'logout']);

Route::get('/', [PostsController::class, 'index']);

Route::prefix('profile')->group(function () {
    Route::get('sources', [SourcesController::class, 'edit']);
    Route::post('sources', [SourcesController::class, 'update']);
    Route::post('sources/delete', [SourcesController::class, 'delete']);
});

Route::post('{post}/add-vote', [VotesController::class, 'store']);
Route::post('{post}/remove-vote', [VotesController::class, 'delete']);

Route::get('{post}', [PostsController::class, 'show']);
