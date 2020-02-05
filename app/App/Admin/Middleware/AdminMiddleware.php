<?php

namespace App\Admin\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /** @var \Domain\User\Models\User $user */
        $user = $request->user();

        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        return abort(Response::HTTP_FORBIDDEN);
    }
}
