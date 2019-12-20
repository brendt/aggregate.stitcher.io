<?php

namespace App\User\Middleware;

use Closure;
use Domain\User\Models\User;

class CurrentUserMiddleware
{
    public function handle($request, Closure $next)
    {
        app()->singleton(User::class, fn () => current_user());

        return $next($request);
    }
}
