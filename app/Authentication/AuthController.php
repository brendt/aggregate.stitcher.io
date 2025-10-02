<?php

namespace App\Authentication;

use Tempest\Auth\Authentication\Authenticatable;
use Tempest\Auth\Authentication\Authenticator;
use Tempest\Auth\OAuth\OAuthClient;
use Tempest\Auth\OAuth\OAuthUser;
use Tempest\Container\Tag;
use Tempest\Core\AppConfig;
use Tempest\Database\PrimaryKey;
use Tempest\Http\Request;
use Tempest\Http\Response;
use Tempest\Http\Responses\Redirect;
use Tempest\Http\Session\Session;
use Tempest\Router\Get;
use Tempest\View\View;
use function Tempest\env;
use function Tempest\Router\uri;

final class AuthController
{
    #[Get('/login')]
    public function login(Authenticator $authenticator, AppConfig $appConfig): Response|View
    {
        if ($appConfig->environment->isLocal() && env('AUTO_LOGIN')) {
            $authenticator->authenticate(User::get(new PrimaryKey(1)));
        }

        if ($authenticator->current()) {
            return new Redirect('/');
        }

        return \Tempest\view('login.view.php');
    }

    #[Get('/logout')]
    public function logout(Authenticator $authenticator): Redirect
    {
        $authenticator->deauthenticate();

        return new Redirect(uri([self::class, 'login']));
    }

    #[Get('/auth/google')]
    public function google(
        Request $request,
        #[Tag('google')] OAuthClient $oauth,
    ): Response {
        $code = $request->get('code');

        if ($code === null) {
            return $oauth->createRedirect();
        }

        $oauth->authenticate($request, function (OAuthUser $oauthUser): Authenticatable {
            $user = User::select()
                ->where('email = ?', $oauthUser->email)
                ->first();

            if (! $user) {
                $user = User::create(
                    email: $oauthUser->email,
                    name: $oauthUser->name,
                    role: Role::USER,
                );
            }

            return $user;
        });

        return new Redirect('/');
    }
}
