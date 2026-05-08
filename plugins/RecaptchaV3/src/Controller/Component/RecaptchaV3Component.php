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
use RecaptchaV3\ActionSet;

/**
 * RecaptchaV3 component
 */
class RecaptchaV3Component extends Component
{
    /**
     * @var ActionSet
     */
    public readonly ActionSet $actions;

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
        $this->actions = new ActionSet();
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
     * 
     * @return Assessment|null
     */
    public function getAssessment(): ?Assessment
    {
        return $this->getRequest()->getAttribute('recaptchav3.assessment');
    }

    /**
     * Set the site key on the view
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

            $actionName = $assessment->getAction();
            $action = $this->actions->get($actionName);

            if ($action === null) {
                throw new InternalErrorException(sprintf('Missing action for %s', $actionName));
            }

            if (!$assessment->evaluate($action->getEvaluator())) {
                $event->stopPropagation();
                $this->getController()->Flash->error(__('Recaptcha failed'));
                $this->getController()->redirect($action->getOnFailRedirect());
            }
        }
    }
}
