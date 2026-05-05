<?php
declare(strict_types=1);

namespace RecaptchaV3\Rule;

use Closure;
use Psr\Http\Message\UriInterface;

class Rule
{
    public function __construct(
        private string $action,
        private Closure $handler,
        private array|string|UriInterface $onFailRedirect,
    ) {
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getHandler(): Closure
    {
        return $this->handler;
    }

    public function getOnFailRedirect(): array|string|UriInterface
    {
        return $this->onFailRedirect;
    }
}