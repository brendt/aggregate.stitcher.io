<?php

namespace App\User\Controllers;

use Support\Controller;
use App\Feed\Controllers\PostsController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

final class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->action([PostsController::class, 'index']);
    }
}
