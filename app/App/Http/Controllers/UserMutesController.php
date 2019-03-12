<?php

namespace App\Http\Controllers;

use Domain\User\Models\User;

final class UserMutesController
{
    public function index(User $user)
    {
        $mutes = $user->mutes;

        return view('userMutes.index', [
            'user' => $user,
            'mutes' => $mutes,
        ]);
    }
}
