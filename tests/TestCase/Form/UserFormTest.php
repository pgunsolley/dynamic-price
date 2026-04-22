<?php
declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\UserForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\UserForm Test Case
 */
class UserFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\UserForm
     */
    protected $User;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->User = new UserForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->User);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Form\UserForm::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
