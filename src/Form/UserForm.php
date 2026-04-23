<?php
declare(strict_types=1);

namespace App\Form;

use App\Form\Enum\UserFormResult;
use App\Model\Entity\User;
use Cake\Form\Schema;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Validation\Validator;

/**
 * User Form.
 * 
 * Use for validating a user's email and password.
 * The password-verified User will be fetched and stored.
 */
class UserForm extends EmailForm
{
    use LocatorAwareTrait;

    protected string $defaultTable = 'Users';

    private ?User $user = null;

    private bool $passwordCheckResult = false;

    private UserFormResult $result = UserFormResult::Pending;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getPasswordCheckResult(): bool
    {
        return $this->passwordCheckResult;
    }

    public function getResult(): UserFormResult
    {
        if (!empty($this->getErrors())) {
            return UserFormResult::ValidationError;
        }

        return $this->result;
    }

    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return parent
            ::_buildSchema($schema)
            ->addField('password', 'password');
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        return parent
            ::validationDefault($validator)
            ->scalar(
                field: 'password',
                message: 'Must be a string',
            )
            ->maxLength(
                field: 'password',
                max: 255,
                message: 'Must not be longer than 255 characters',
            )
            ->requirePresence(
                field: 'password',
                message: 'Password is missing from data',
            )
            ->notEmptyString(
                field: 'password',
                message: 'Must not be empty',
            );
    }

    protected function process(array $data): bool
    {
        $email = $data['email'];
        $password = $data['password'];

        $user = $this->fetchTable()->find('byEmail', email: $email)->first();
        
        if (!$user) {
            $this->result = UserFormResult::UserNotFound;
            return false;
        }

        $this->user = $user;
        $this->passwordCheckResult = $user->checkPassword($password);
        $this->result = $this->passwordCheckResult ? UserFormResult::Success : UserFormResult::InvalidPassword;
        return $this->passwordCheckResult;
    }
}
