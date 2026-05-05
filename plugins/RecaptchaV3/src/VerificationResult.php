<?php
declare(strict_types=1);

namespace RecaptchaV3;

/**
 * Verification endpoint response
 * 
 * {
 *   "success": true|false,      // whether this request was a valid reCAPTCHA token for your site
 *   "score": number             // the score for this request (0.0 - 1.0)
 *   "action": string            // the action name for this request (important to verify)
 *   "challenge_ts": timestamp,  // timestamp of the challenge load (ISO format yyyy-MM-dd'T'HH:mm:ssZZ)
 *   "hostname": string,         // the hostname of the site where the reCAPTCHA was solved
 *   "error-codes": [...]        // optional
 * }
 */
class VerificationResult
{
    private bool $validated = false;

    private bool $result = false;

    public function __construct(private array $data)
    {
    }

    public function isValidated(): bool
    {
        return $this->validated;
    }

    public function isValid(): bool
    {
        return $this->result;
    }

    /**
     * @param callable(array): bool $validator
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