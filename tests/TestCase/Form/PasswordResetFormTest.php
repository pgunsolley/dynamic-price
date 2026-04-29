<?php
declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\PasswordResetForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\PasswordResetForm Test Case
 */
class PasswordResetFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\PasswordResetForm
     */
    protected $PasswordReset;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->PasswordReset = new PasswordResetForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PasswordReset);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Form\PasswordResetForm::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
