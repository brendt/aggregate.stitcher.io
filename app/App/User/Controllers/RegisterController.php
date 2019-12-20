<?php

namespace App\User\Controllers;

use Support\Controller;
use App\Feed\Controllers\PostsController;
use Domain\User\Actions\CreateUserAction;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function register(
        Request $request,
        CreateUserAction $createUserAction
    ) {
        $this->validator($request->all())->validate();

        $data = $request->all();

        $user = $createUserAction($data['email'], bcrypt($data['password']));

        $this->guard()->login($user);

        return redirect()->action([PostsController::class, 'index']);
    }
}
