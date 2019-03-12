<?php

namespace App\Http\Controllers\Auth;

final class LogoutController
{
    public function logout()
    {
        return view('auth.logout');
    }
}
