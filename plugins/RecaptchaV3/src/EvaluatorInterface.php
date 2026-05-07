<?php
declare(strict_types=1);

namespace RecaptchaV3;

/**
 * Handles assessment evaluation
 */
interface EvaluatorInterface
{
    /**
     * Evaluates the assessment data
     * 
     * @param array $data
     * @return bool
     */
    public function evaluate(array $data): bool;
}
