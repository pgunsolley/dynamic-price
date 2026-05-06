<?php
declare(strict_types=1);

namespace RecaptchaV3\Controller\Component;

use RecaptchaV3\Service\RecaptchaV3Service;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\EventInterface;
use Cake\Http\ServerRequest;
use RecaptchaV3\RuleSet;
use RecaptchaV3\VerificationResult;

/**
 * RecaptchaV3 component
 */
class RecaptchaV3Component extends Component
{
    /**
     * @var RuleSet
     */
    public readonly RuleSet $rules;

    /**
     * @param ComponentRegistry $registry
     * @param RecaptchaV3Service $recaptchaV3
     */
    public function __construct(
        ComponentRegistry $registry,
        private RecaptchaV3Service $recaptchaV3,
        array $config = [],
    ) {
        parent::__construct($registry, $config);
        $this->rules = new RuleSet();
    }

    /**
     * Calls the VerificationResult validate method
     * 
     * @param callable $validator The validation handler
     * @return bool The result of the validator, or false 
     *  if the VerificationResult is not set in the Request.
     */
    public function validate(callable $validator): bool
    {
        return !!$this->getResult()?->validate($validator);
    }

    /**
     * Returns the VerificationResult set in the Request
     * 
     * @return VerificationResult|null The VerificationResult,
     *  or null if not set in the Request.
     */
    public function getResult(): ?VerificationResult
    {
        return $this->getRequest()->getAttribute('recaptchaV3Result');
    }

    /**
     * Returns the RecaptchaV3 service
     * 
     * @return RecaptchaV3Service
     */
    public function getService(): RecaptchaV3Service
    {
        return $this->recaptchaV3;
    }

    /**
     * Sets the site key on the view builder
     * 
     * @return void
     */
    public function setSiteKey(): void
    {
        $this->getController()->set([
            'recaptchaV3SiteKey' => $this->recaptchaV3->getSiteKey(),
        ]);
    }

    /**
     * Returns the ServerRequest
     * 
     * @return ServerRequest
     */
    private function getRequest(): ServerRequest
    {
        return $this->getController()->getRequest();
    }

    /**
     * Returns the name of the current controller action
     * 
     * @return string
     */
    private function getCurrentAction(): string
    {
        return $this->getRequest()->getParam('action');
    }

    /**
     * Controller.beforeFilter event hook
     * 
     * @param EventInterface $event
     * @return void
     */
    public function beforeFilter(EventInterface $event)
    {
        if ($this->getRequest()->is('post')) {
            $rule = $this->rules->get($this->getCurrentAction());

            if ($rule !== null) {
                if (!$this->validate($rule->getValidator())) {
                    $event->stopPropagation();
                    $this->getController()->Flash->error(__('Recaptcha failed'));
                    $this->getController()->redirect($rule->getOnFailRedirect());
                }
            }
        }
    }

    /**
     * Controller.beforeRender event hook
     * 
     * @return void
     */
    public function beforeRender()
    {
        if ($this->rules->get($this->getCurrentAction())) {
            $this->setSiteKey();
        }
    }
}
