<?php
declare(strict_types=1);

namespace RecaptchaV3;

use InvalidArgumentException;

/**
 * A set of Action unique by controller action name
 */
class ActionSet
{
    /** 
     * An array of Action
     * 
     * @var Action[]
     */
    private array $actions = [];

    /**
     * @param Action|array $actions
     */
    public function __construct(Action|array $actions = [])
    {
        $this->add($actions);
    }

    /**
     * Adds a Action to the set
     * 
     * Uniqueness is guaranteed by the Action action name.
     * 
     * @param Action|Action[] $actions Action instance
     * @throws InvalidArgumentException If a Action already exists with the same 
     *  controller action name
     * @return $this
     */
    public function add(Action|array $actions): static
    {
        if (!is_array($actions)) {
            $actions = [$actions];
        }

        foreach ($actions as $action) {
            $name = $action->getName();

            if ($this->get($name)) {
                throw new InvalidArgumentException(sprintf('%s action already defined', $name));
            }

            $this->actions[] = $action;
        }

        return $this;
    }

    /**
     * Finds and returns the Action for the corresponding recaptcha action
     * 
     * @param string $name The name of the recaptcha action
     * @return \RecaptchaV3\Action|null Returns Action if found, otherwise null
     */
    public function get(string $name): ?Action
    {
        return array_find($this->actions, fn($action) => $action->getName() === $name);
    }
}
