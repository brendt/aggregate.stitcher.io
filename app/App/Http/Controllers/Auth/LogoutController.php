<?php

namespace App\Http\Controllers\Auth;

class LogoutController
{
    public function logout()
    {
        return view('auth.logout');
    }
}
