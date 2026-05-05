<?php
declare(strict_types=1);

namespace RecaptchaV3\Controller\Component\RecaptchaV3;

use InvalidArgumentException;

class ActionConfigurationSet
{
    /** @var \RecaptchaV3\Controller\Component\RecaptchaV3\ActionConfiguration[] $actionConfigurations */
    private array $actionConfigurations = [];

    /**
     * @param \RecaptchaV3\Controller\Component\RecaptchaV3\ActionConfiguration|\RecaptchaV3\Controller\Component\RecaptchaV3\ActionConfiguration[] $config
     * @return void
     */
    public function add(ActionConfiguration|array $config)
    {
        if (!is_array($config)) {
            $config = [$config];
        }

        foreach ($config as $conf) {
            $action = $conf->getAction();

            if ($this->exists($action)) {
                throw new InvalidArgumentException(sprintf('Config for action %s already exists', $action));
            }

            $this->actionConfigurations[] = $conf;
        }
    }

    /**
     * @param string $action The name of the action
     * @return \RecaptchaV3\Controller\Component\RecaptchaV3\ActionConfiguration|null
     */
    public function get(string $action): ?ActionConfiguration
    {
        return array_find($this->actionConfigurations, fn($config) => $config->getAction() === $action);
    }

    /**
     * @param string $action The name of the action
     * @return bool
     */
    public function exists(string $action): bool
    {
        foreach ($this->actionConfigurations as $actionConfiguration) {
            if ($actionConfiguration->getAction() === $action) {
                return true;
            }
        }

        return false;
    }
}