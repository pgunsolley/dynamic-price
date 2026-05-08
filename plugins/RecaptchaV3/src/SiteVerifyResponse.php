<?php
declare(strict_types=1);

namespace RecaptchaV3;

use Cake\I18n\DateTime;

class SiteVerifyResponse
{
    public function __construct(
        private readonly bool $success,
        private readonly float $score,
        private readonly string $action,
        private readonly string $challengeTs,
        private readonly string $hostname,
        private readonly array $errorCodes,
    ) {
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getChallengeTs(): DateTime
    {
        return new DateTime($this->challengeTs);
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function getErrorCodes(): array
    {
        return $this->errorCodes;
    }
}
