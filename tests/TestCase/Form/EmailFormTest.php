<?php
declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\EmailForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\EmailForm Test Case
 */
class EmailFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\EmailForm
     */
    protected $Email;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Email = new EmailForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Email);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Form\EmailForm::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
