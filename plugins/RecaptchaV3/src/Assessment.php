<?php
declare(strict_types=1);

namespace RecaptchaV3;

/**
 * RecaptchaV3 assessment
 */
class Assessment
{
    /**
     * @var bool
     */
    private bool $evaluated = false;

    /**
     * @var bool
     */
    private bool $result = false;

    /**
     * @param SiteVerifyResponse $response The response data
     */
    public function __construct(private readonly SiteVerifyResponse $response)
    {
    }

    /**
     * Returns the recaptcha action
     * 
     * @return string
     */
    public function getAction(): string
    {
        return $this->response->getAction();
    }

    /**
     * Returns the value of the resolved flag
     * 
     * @return bool
     */
    public function isEvaluated(): bool
    {
        return $this->evaluated;
    }

    /**
     * Returns the value of the result flag
     * 
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->result;
    }

    /**
     * Calls the evaluator once, returning the evaluator result
     * 
     * The resolved flag will be set to `true` regardless of the evaluator result.
     *
     * This method will not run the evaluator if the resolved flag is already `true`.
     * 
     * @param EvaluatorInterface $evaluator
     * @return bool
     */
    public function evaluate(EvaluatorInterface $evaluator): bool
    {
        if ($this->evaluated) {
            return $this->result;
        }

        $this->evaluated = true;
        return $this->result = $evaluator->evaluate($this->response);
    }
}
