<?php
declare(strict_types=1);

namespace RecaptchaV3;

use InvalidArgumentException;

/**
 * RuleSet
 * 
 * A set of Rule unique by controller action name
 */
class RuleSet
{
    /** 
     * An array of Rule
     * 
     * @var Rule[]
     */
    private array $rules = [];

    /**
     * Adds a Rule to the set
     * 
     * Uniqueness is guaranteed by the Rule action name.
     * 
     * @param Rule|Rule[] $rule Rule instance
     * @throws InvalidArgumentException If a Rule already exists with the same 
     *  controller action name
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
     * Finds and returns the Rule for the corresponding recaptcha action
     * 
     * @param string $action The name of the recaptcha action
     * @return \RecaptchaV3\Rule|null Returns Rule if found, otherwise null
     */
    public function get(string $action): ?Rule
    {
        return array_find($this->rules, fn($rule) => $rule->getAction() === $action);
    }
}
