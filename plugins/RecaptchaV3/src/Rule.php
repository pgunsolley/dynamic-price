<?php
declare(strict_types=1);

namespace RecaptchaV3;

use Closure;
use Psr\Http\Message\UriInterface;

class Rule
{
    public function __construct(
        private string $action,
        private Closure $validator,
        private array|string|UriInterface $onFailRedirect,
    ) {
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getValidator(): Closure
    {
        return $this->validator;
    }

    public function getOnFailRedirect(): array|string|UriInterface
    {
        return $this->onFailRedirect;
    }
}