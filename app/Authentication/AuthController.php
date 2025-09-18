<?php

namespace App\Authentication;

use App\Home\HomeController;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\GoogleUser;
use Tempest\Auth\Authentication\Authenticator;
use Tempest\Core\AppConfig;
use Tempest\Database\PrimaryKey;
use Tempest\Http\Request;
use Tempest\Http\Response;
use Tempest\Http\Responses\Invalid;
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
    public function google(Request $request, Session $session, Google $google, Authenticator $authenticator, AppConfig $appConfig): Response
    {
        if ($request->get('error')) {
            return new Invalid($request);
        }

        $code = $request->get('code');

        if ($code === null) {
            $authUrl = $google->getAuthorizationUrl();
            $session->set('oauth2state', $google->getState());

            return new Redirect($authUrl);
        }

        $state = $session->get('oauth2state');

        if ($state === null || $state !== $session->get('oauth2state')) {
            $session->remove('oauth2state');

            return new Invalid($request);
        }

        $token = $google->getAccessToken('authorization_code', [
            'code' => $code,
        ]);

        /** @var GoogleUser $ownerDetails */
        $ownerDetails = $google->getResourceOwner($token);

        $user = User::select()
            ->where('email = ?', $ownerDetails->getEmail())
            ->first();

        if (! $user) {
            $user = User::create(
                email: $ownerDetails->getEmail(),
                name: $ownerDetails->getName(),
            );
        }

        if ($appConfig->environment->isProduction() && $user->email !== env('ADMIN_EMAIL')) {
            return new Invalid($request);
        }

        $authenticator->authenticate($user);

        return new Redirect('/');
    }
}
