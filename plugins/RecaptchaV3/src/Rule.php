<?php
declare(strict_types=1);

namespace RecaptchaV3;

use Closure;
use Psr\Http\Message\UriInterface;

/**
 * Rule
 * 
 * Maps a controller action to a recaptcha result validator.
 */
class Rule
{
    /**
     * @param string $action The name of the controller action
     * @param Closure $validator The validator Closure
     * @param array|string|UriInterface $onFailRedirect The url to redirect to on validator failure
     */
    public function __construct(
        private string $action,
        private Closure $validator,
        private array|string|UriInterface $onFailRedirect,
    ) {
    }

    /**
     * Returns the controller action name
     * 
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Returns the validator
     * 
     * @return Closure
     */
    public function getValidator(): Closure
    {
        return $this->validator;
    }

    /**
     * Returns the redirect url
     * 
     * @return array|string|UriInterface
     */
    public function getOnFailRedirect(): array|string|UriInterface
    {
        return $this->onFailRedirect;
    }
}