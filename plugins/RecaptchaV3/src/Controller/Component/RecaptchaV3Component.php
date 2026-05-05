<?php
declare(strict_types=1);

namespace RecaptchaV3\Controller\Component;

use RecaptchaV3\Service\RecaptchaV3Service;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\EventInterface;
use Cake\Http\ServerRequest;
use Override;
use RecaptchaV3\RuleSet;
use RecaptchaV3\VerificationResult;

/**
 * RecaptchaV3 component
 */
class RecaptchaV3Component extends Component
{
    public readonly RuleSet $rules;

    public function __construct(
        ComponentRegistry $registry,
        private RecaptchaV3Service $recaptchaV3,
        array $config = [],
    ) {
        return parent::__construct($registry, $config);
    }

    #[Override]
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->rules = new RuleSet();
    }

    public function check(callable $handler): bool
    {
        return $this->getResult()->check($handler);
    }

    public function getResult(): ?VerificationResult
    {
        return $this->getRequest()->getAttribute('recaptchaV3Result');
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

    private function getRequest(): ServerRequest
    {
        return $this->getController()->getRequest();
    }

    private function getCurrentAction(): string
    {
        return $this->getRequest()->getParam('action');
    }

    public function beforeFilter(EventInterface $event)
    {
        if ($this->getRequest()->is('post')) {
            $rule = $this->rules->get($this->getCurrentAction());

            if ($rule !== null) {
                $handler = $rule->getHandler();

                if (!$this->check($handler)) {
                    $event->stopPropagation();
                    $this->getController()->Flash->error(__('Recaptcha failed'));
                    $this->getController()->redirect($rule->getOnFailRedirect());
                }
            }
        }
    }

    public function beforeRender()
    {
        if ($this->rules->get($this->getCurrentAction())) {
            $this->setSiteKey();
        }
    }
}
