<?php
declare(strict_types=1);

namespace RecaptchaV3\Controller\Component;

use RecaptchaV3\Service\RecaptchaV3Service;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\EventInterface;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\ServerRequest;
use RecaptchaV3\Assessment;
use RecaptchaV3\RuleSet;

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
     * @param array $config
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
     * Returns the RecaptchaV3Service
     * 
     * @return RecaptchaV3Service
     */
    public function getService(): RecaptchaV3Service
    {
        return $this->recaptchaV3;
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
     * Returns the assessment or null if not set
     * 
     * The RecaptchaV3Middleware will set the assessment on the request
     * upon a successful verification call.
     */
    public function getAssessment(): ?Assessment
    {
        return $this->getRequest()->getAttribute('recaptchav3.assessment');
    }

    public function setSiteKey(): void
    {
        $this->getController()->set([
            'recaptchaV3SiteKey' => $this->recaptchaV3->getSiteKey(),
        ]);
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
            $assessment = $this->getAssessment();

            if ($assessment === null) {
                return;
            }

            $action = $assessment->getAction();
            $rule = $this->rules->get($action);

            if ($rule === null) {
                throw new InternalErrorException(sprintf('Missing rule for action %s', $action));
            }

            if (!$assessment->evaluate($rule->getEvaluator())) {
                $event->stopPropagation();
                $this->getController()->Flash->error(__('Recaptcha failed'));
                $this->getController()->redirect($rule->getOnFailRedirect());
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

    }
}
