<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class CheckIfBannedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->banned_at) {
            Auth::logout();
            return redirect()->to('/');
        }

        return $next($request);
    }
}
