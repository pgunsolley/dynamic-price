<?php
declare(strict_types=1);

namespace App\RecaptchaV3;

use Cake\Http\Exception\NotImplementedException;
use Override;
use RecaptchaV3\EvaluatorInterface;

class UsersEvaluator implements EvaluatorInterface
{
    /**
     * 
     */
    public function login(): bool
    {
        throw new NotImplementedException();
    }

    public function register(): bool
    {
        throw new NotImplementedException();
    }

    public function requestPasswordReset(): bool
    {
        throw new NotImplementedException();
    }

    #[Override]
    public function evaluate(array $data): bool
    {
        throw new NotImplementedException();
    }
}