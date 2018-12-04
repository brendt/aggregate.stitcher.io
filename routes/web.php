<?php

use App\Http\Controllers\PostsController;

Route::get('/', [PostsController::class, 'index']);

Route::get('/{post}', [PostsController::class, 'show']);
