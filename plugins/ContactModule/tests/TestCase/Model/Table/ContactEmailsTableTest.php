<?php
declare(strict_types=1);

namespace ContactManager\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ContactManager\Model\Table\ContactEmailsTable;

/**
 * ContactManager\Model\Table\ContactEmailsTable Test Case
 */
class ContactEmailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ContactManager\Model\Table\ContactEmailsTable
     */
    protected $ContactEmails;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ContactManager.ContactEmails',
        'plugin.ContactManager.Contacts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ContactEmails') ? [] : ['className' => ContactEmailsTable::class];
        $this->ContactEmails = $this->getTableLocator()->get('ContactEmails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ContactEmails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \ContactManager\Model\Table\ContactEmailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \ContactManager\Model\Table\ContactEmailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
