<?php

namespace App\User\Middleware;

use App\Feed\Controllers\PostsController;
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
