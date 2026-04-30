<?php
declare(strict_types=1);

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * PasswordReset Form.
 */
class PasswordConfirmationForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema
            ->addField('password', 'password')
            ->addField('password_confirm', 'password');
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
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
            
        $validator
            ->sameAs(
                field: 'password_confirm',
                secondField: 'password',
                message: 'Password does not match',
            );

        return $validator;
    }
}
