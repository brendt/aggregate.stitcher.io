<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;

class AcceptInvitationController extends Controller
{
    public function __invoke(string $code)
    {
        $user = User::query()
            ->where('invitation_code', $code)
            ->whereNull('password')
            ->firstOrFail();

        return view('acceptInvite', [
            'user' => $user,
            'code' => $code,
        ]);
    }
}
