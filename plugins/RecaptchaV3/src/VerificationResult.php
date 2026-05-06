<?php
declare(strict_types=1);

namespace RecaptchaV3;

/**
 * RecaptchaV3 verification result
 */
class VerificationResult
{
    /**
     * Flag that is set to true if validate has been called
     * 
     * @var bool
     */
    private bool $validated = false;

    /**
     * Flag that is set to true if validate returned true
     * 
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
     * Returns the value of the validated flag
     * 
     * @return bool
     */
    public function isValidated(): bool
    {
        return $this->validated;
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
     * Calls the validator once, returning the validator result
     * 
     * The validated flag will be set to `true` regardless of the validator result.
     *
     * This method will not run the validator if the validated flag is already `true`.
     * 
     * @param callable(array): bool $validator The validation handler
     * @return bool
     */
    public function validate(callable $validator): bool
    {
        if ($this->isValidated()) {
            return $this->result;
        }

        $this->validated = true;
        $this->result = $validator($this->data);
        return $this->result;
    }
}