<?php
declare(strict_types=1);

namespace App\Authentication;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Psr\Http\Message\ServerRequestInterface;

class AppAuthenticationServiceProvider implements AuthenticationServiceProviderInterface
{
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        return new AuthenticationService([
            'authenticators' => [
                'Authentication.Session',
            ],
            'unauthenticatedRedirect' => ['_name' => 'users:login'],
        ]);
    }
}