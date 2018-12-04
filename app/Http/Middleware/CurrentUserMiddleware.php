<?php

namespace App\Http\Middleware;

use Closure;
use Domain\User\Models\User;

class CurrentUserMiddleware
{
    public function handle($request, Closure $next)
    {
        app()->singleton(User::class, function () {
            return current_user();
        });

        return $next($request);
    }
}
