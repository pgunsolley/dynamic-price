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
 *
 * This class is to help consumers when inspecting the result
 */
class VerificationResult
{
    private bool $checked = false;

    private bool $result = false;

    public function __construct(private array $data)
    {
    }

    public function isChecked(): bool
    {
        return $this->checked;
    }

    public function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @param callable(array): bool $handler
     */
    public function check(callable $handler): bool
    {
        if ($this->isChecked()) {
            return $this->result;
        }

        $this->checked = true;
        $this->result = $handler($this->data);
        return $this->result;
    }
}