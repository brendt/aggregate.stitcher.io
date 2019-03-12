<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PrivacyController;

Route::get('/', [PostsController::class, 'index']);
Route::get('latest', [PostsController::class, 'latest']);
Route::get('top', [PostsController::class, 'top']);
Route::get('topic/{topic}', [PostsController::class, 'topic']);
Route::get('tag/{tag}', [PostsController::class, 'tag']);
Route::get('source/{sourceByWebsite}', [PostsController::class, 'source']);

Route::get('privacy', PrivacyController::class);
Route::get('about', AboutController::class);
