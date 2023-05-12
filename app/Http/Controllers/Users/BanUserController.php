<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

final class BanUserController
{
    public function __invoke(User $user, Request $request)
    {
        $user->update([
            'banned_at' => now(),
            'remember_token' => null,
        ]);

        return redirect()->to($request->get('to', RouteServiceProvider::HOME));
    }
}
