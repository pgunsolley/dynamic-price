<?php
declare(strict_types=1);

namespace RecaptchaV3;

use InvalidArgumentException;

class RuleSet
{
    /** @var \RecaptchaV3\Rule[] $rules */
    private array $rules = [];

    /**
     * @param \RecaptchaV3\Rule|\RecaptchaV3\Rule[] $rule
     * @return void
     */
    public function add(Rule|array $rule)
    {
        if (!is_array($rule)) {
            $rule = [$rule];
        }

        foreach ($rule as $_rule) {
            $action = $_rule->getAction();

            if ($this->get($action)) {
                throw new InvalidArgumentException(sprintf('Rule for action %s already exists', $action));
            }

            $this->rules[] = $_rule;
        }
    }

    /**
     * @param string $action The name of the action
     * @return \RecaptchaV3\Rule|null
     */
    public function get(string $action): ?Rule
    {
        return array_find($this->rules, fn($rule) => $rule->getAction() === $action);
    }
}
