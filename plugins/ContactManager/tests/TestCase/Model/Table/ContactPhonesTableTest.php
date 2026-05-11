<?php
declare(strict_types=1);

namespace ContactManager\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ContactManager\Model\Table\ContactPhonesTable;

/**
 * ContactManager\Model\Table\ContactPhonesTable Test Case
 */
class ContactPhonesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ContactManager\Model\Table\ContactPhonesTable
     */
    protected $ContactPhones;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ContactManager.ContactPhones',
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
        $config = $this->getTableLocator()->exists('ContactPhones') ? [] : ['className' => ContactPhonesTable::class];
        $this->ContactPhones = $this->getTableLocator()->get('ContactPhones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ContactPhones);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \ContactManager\Model\Table\ContactPhonesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \ContactManager\Model\Table\ContactPhonesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
