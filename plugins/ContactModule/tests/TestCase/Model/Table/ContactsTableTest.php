<?php
declare(strict_types=1);

namespace ContactManager\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ContactManager\Model\Table\ContactsTable;

/**
 * ContactManager\Model\Table\ContactsTable Test Case
 */
class ContactsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ContactManager\Model\Table\ContactsTable
     */
    protected $Contacts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ContactManager.Contacts',
        'plugin.ContactManager.ContactEmails',
        'plugin.ContactManager.ContactLinks',
        'plugin.ContactManager.ContactPhones',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Contacts') ? [] : ['className' => ContactsTable::class];
        $this->Contacts = $this->getTableLocator()->get('Contacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Contacts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \ContactManager\Model\Table\ContactsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
