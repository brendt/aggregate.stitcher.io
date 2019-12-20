<?php

namespace App\User\Controllers;

use Support\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

final class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }
}
