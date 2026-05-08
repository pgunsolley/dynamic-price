<?php
declare(strict_types=1);

namespace RecaptchaV3;

use Psr\Http\Message\UriInterface;

/**
 * Maps a recaptcha action to a recaptcha assessment evaluator.
 */
class Action
{
    /**
     * @param string $name The name of the recaptcha action
     * @param EvaluatorInterface $evaluator
     * @param array|string|UriInterface|null $onFailRedirect
     */
    public function __construct(
        private string $name,
        private EvaluatorInterface $evaluator,
        private array|string|UriInterface|null $onFailRedirect = null,
    ) {
    }

    /**
     * Returns the recaptcha action name
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
