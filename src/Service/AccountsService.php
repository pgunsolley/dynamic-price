<?php
declare(strict_types=1);

namespace App\Service;

class AccountsService
{
    public function __construct(
        public readonly bool $requireEmailVerification = true,
    ) {
    }
}
