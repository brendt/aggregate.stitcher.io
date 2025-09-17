<?php

namespace App\Authentication;

use Tempest\Auth\Authentication\Authenticator;
use Tempest\Discovery\SkipDiscovery;
use Tempest\Http\Request;
use Tempest\Http\Response;
use Tempest\Http\Responses\Redirect;
use Tempest\Router\HttpMiddleware;
use Tempest\Router\HttpMiddlewareCallable;
use function Tempest\Router\uri;

#[SkipDiscovery]
final readonly class AuthMiddleware implements HttpMiddleware
{
    public function __construct(
        private Authenticator $authenticator,
    ) {}

    public function __invoke(Request $request, HttpMiddlewareCallable $next): Response
    {
        if ($this->authenticator->current() === null) {
            return new Redirect(uri([AuthController::class, 'login']));
        }

        return $next($request);
    }
}
