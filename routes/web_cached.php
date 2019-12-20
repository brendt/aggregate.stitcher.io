<?php

use App\Feed\Controllers\AboutController;
use App\Feed\Controllers\PostsController;
use App\User\Controllers\PrivacyController;

Route::get('/discover', [PostsController::class, 'all']);
Route::get('latest', [PostsController::class, 'latest']);
Route::get('top', [PostsController::class, 'top']);
Route::get('topic/{topic}', [PostsController::class, 'topic']);
Route::get('tag/{tag}', [PostsController::class, 'tag']);
Route::get('source/{sourceByWebsite}', [PostsController::class, 'source']);

Route::get('privacy', PrivacyController::class);
Route::get('about', AboutController::class);
