<?php
declare(strict_types=1);

namespace App\RecaptchaV3;

use Override;
use RecaptchaV3\EvaluatorInterface;
use RecaptchaV3\SiteVerifyResponse;

class RequestPasswordResetEvaluator implements EvaluatorInterface
{
    #[Override]
    public function evaluate(SiteVerifyResponse $response): bool
    {
        throw new \Exception('Not implemented');
    }
}
