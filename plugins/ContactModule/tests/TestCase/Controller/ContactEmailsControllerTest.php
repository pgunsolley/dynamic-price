<?php
declare(strict_types=1);

namespace ContactManager\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use ContactManager\Controller\ContactEmailsController;

/**
 * ContactManager\Controller\ContactEmailsController Test Case
 *
 * @link \ContactManager\Controller\ContactEmailsController
 */
class ContactEmailsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ContactManager.ContactEmails',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \ContactManager\Controller\ContactEmailsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \ContactManager\Controller\ContactEmailsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \ContactManager\Controller\ContactEmailsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \ContactManager\Controller\ContactEmailsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \ContactManager\Controller\ContactEmailsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
