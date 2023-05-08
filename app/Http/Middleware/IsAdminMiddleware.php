<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

final class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! ($user->is_admin ?? false)) {
            abort(403);
        }

        return $next($request);
    }
}
