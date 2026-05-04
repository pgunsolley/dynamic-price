<?php
declare(strict_types=1);

namespace RecaptchaV3\Controller\Component;

use RecaptchaV3\Service\RecaptchaV3Service;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * RecaptchaV3 component
 */
class RecaptchaV3Component extends Component
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [
        'actions' => [],
    ];

    protected ?array $result;

    public function __construct(
        ComponentRegistry $registry,
        private RecaptchaV3Service $recaptchaV3,
        array $config = [],
    ) {
        return parent::__construct($registry, $config);
    }

    public function getResult(): ?array
    {
        return $this->result;
    }

    public function getService(): RecaptchaV3Service
    {
        return $this->recaptchaV3;
    }

    public function beforeRender(): void
    {
        $controller = $this->getController();
        $request = $controller->getRequest();

        if (in_array($request->getParam('action'), $this->getConfig('actions'))) {
            $controller->set([
                'recaptchaV3SiteKey' => $this->recaptchaV3->getSiteKey(),
            ]);
        }
    }
}
