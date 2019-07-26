<?php

namespace App\Http\Middleware;

use App\Http\Controllers\PostsController;
use Closure;
use Illuminate\Http\Request;

final class RedirectToUserFeedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /** @var \Domain\User\Models\User $user */
        $user = $request->user();

        if ($user) {
            return redirect()->action([PostsController::class, 'all']);
        }

        return $next($request);
    }
}
