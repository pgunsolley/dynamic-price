<?php
declare(strict_types=1);

namespace RecaptchaV3;

use Psr\Http\Message\UriInterface;

/**
 * Rule
 * 
 * Maps a recaptcha action to a recaptcha assessment evaluator.
 */
class Rule
{
    /**
     * @param string $action The name of the recaptcha action
     * @param EvaluatorInterface $evaluator
     * @param array|string|UriInterface $onFailRedirect
     */
    public function __construct(
        private string $action,
        private EvaluatorInterface $evaluator,
        private array|string|UriInterface $onFailRedirect,
    ) {
    }

    /**
     * Returns the recaptcha action name
     * 
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Returns the evaluator
     * 
     * @return EvaluatorInterface
     */
    public function getEvaluator(): EvaluatorInterface
    {
        return $this->evaluator;
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
