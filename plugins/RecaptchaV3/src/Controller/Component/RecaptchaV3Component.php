<?php
declare(strict_types=1);

namespace RecaptchaV3\Controller\Component;

use RecaptchaV3\Service\RecaptchaV3Service;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use RecaptchaV3\VerificationResult;

/**
 * RecaptchaV3 component
 */
class RecaptchaV3Component extends Component
{
    public function __construct(
        ComponentRegistry $registry,
        private RecaptchaV3Service $recaptchaV3,
        array $config = [],
    ) {
        return parent::__construct($registry, $config);
    }

    public function check(callable $handler): bool
    {
        return $this->getResult()->check($handler);
    }

    public function getResult(): ?VerificationResult
    {
        return $this->getController()->getRequest()->getAttribute('recaptchaV3Result');
    }

    public function getService(): RecaptchaV3Service
    {
        return $this->recaptchaV3;
    }

    public function setSiteKey(): void
    {
        $this->getController()->set([
            'recaptchaV3SiteKey' => $this->recaptchaV3->getSiteKey(),
        ]);
    }
}
