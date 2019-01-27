<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\User\Actions\ResetPasswordAction;
use Domain\User\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function resetPassword(User $user, $password)
    {
        $resetPasswordAction = new ResetPasswordAction();

        $resetPasswordAction($user, Hash::make($password));

        $this->guard()->login($user);
    }
}
