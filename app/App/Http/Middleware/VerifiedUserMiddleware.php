<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifiedUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /** @var \Domain\User\Models\User $user */
        $user = $request->user();

        if ($user && $user->isVerified()) {
            return $next($request);
        }

        return response()->view('verification.index');
    }
}
