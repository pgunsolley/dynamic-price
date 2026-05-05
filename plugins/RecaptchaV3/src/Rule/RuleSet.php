<?php
declare(strict_types=1);

namespace RecaptchaV3\Rule;

use InvalidArgumentException;

class RuleSet
{
    /** @var \RecaptchaV3\Rule\Rule[] $rules */
    private array $rules = [];

    /**
     * @param \RecaptchaV3\Rule\Rule|\RecaptchaV3\Rule\Rule[] $config
     * @return void
     */
    public function add(Rule|array $config)
    {
        if (!is_array($config)) {
            $config = [$config];
        }

        foreach ($config as $conf) {
            $action = $conf->getAction();

            if ($this->get($action)) {
                throw new InvalidArgumentException(sprintf('Rule for action %s already exists', $action));
            }

            $this->rules[] = $conf;
        }
    }

    /**
     * @param string $action The name of the action
     * @return \RecaptchaV3\Rule\Rule|null
     */
    public function get(string $action): ?Rule
    {
        return array_find($this->rules, fn($config) => $config->getAction() === $action);
    }
}
