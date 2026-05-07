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
     * @param array $data The response data
     * 
     * Example when returned by `RecaptchaV3Service::verifyRecaptchaResponse`
     * ```php
     * [
     *     // whether this request was a valid reCAPTCHA token for your site
     *     "success" => true|false,
     *     // the score for this request (0.0 - 1.0)
     *     "score" => number,
     *     // the action name for this request (important to verify)
     *     "action" => string,
     *     // timestamp of the challenge load (ISO format yyyy-MM-dd'T'HH:mm:ssZZ)
     *     "challenge_ts" => timestamp,
     *     // the hostname of the site where the reCAPTCHA was solved
     *     "hostname" => string,
     *     // optional
     *     "error-codes" => [...],
     *  ]
     * ```
     */
    public function __construct(private readonly array $data)
    {
    }

    /**
     * Returns the recaptcha action
     * 
     * @return string
     */
    public function getAction(): string
    {
        return $this->data['action'];
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
        return $this->result = $evaluator->evaluate($this->data);
    }
}
