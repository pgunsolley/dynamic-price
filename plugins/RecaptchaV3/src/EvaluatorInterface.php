<?php
declare(strict_types=1);

namespace RecaptchaV3;

/**
 * Handles assessment evaluation
 */
interface EvaluatorInterface
{
    /**
     * Evaluates the siteverify response data
     * 
     * @param SiteVerifyResponse $response
     * @return bool
     */
    public function evaluate(SiteVerifyResponse $response): bool;
}
