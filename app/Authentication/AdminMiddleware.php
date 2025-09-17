<?php

namespace App\Authentication;

use App\Home\HomeController;
use Tempest\Auth\Authentication\Authenticator;
use Tempest\Discovery\SkipDiscovery;
use Tempest\Http\Request;
use Tempest\Http\Response;
use Tempest\Http\Responses\Redirect;
use Tempest\Router\HttpMiddleware;
use Tempest\Router\HttpMiddlewareCallable;
use function Tempest\Router\uri;

#[SkipDiscovery]
final readonly class AdminMiddleware implements HttpMiddleware
{
    public function __construct(
        private Authenticator $authenticator,
    ) {}

    public function __invoke(Request $request, HttpMiddlewareCallable $next): Response
    {
        $user = $this->authenticator->current();

        if (! $user instanceof User) {
            return new Redirect(uri([AuthController::class, 'login']));
        }

        if (! $user->isAdmin) {
            return new Redirect('/');
        }

        return $next($request);
    }
}
