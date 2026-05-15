<?php
declare(strict_types=1);

namespace ContactManager\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ContactManager\Model\Table\ContactLinksTable;

/**
 * ContactManager\Model\Table\ContactLinksTable Test Case
 */
class ContactLinksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ContactManager\Model\Table\ContactLinksTable
     */
    protected $ContactLinks;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ContactManager.ContactLinks',
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
        $config = $this->getTableLocator()->exists('ContactLinks') ? [] : ['className' => ContactLinksTable::class];
        $this->ContactLinks = $this->getTableLocator()->get('ContactLinks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ContactLinks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \ContactManager\Model\Table\ContactLinksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \ContactManager\Model\Table\ContactLinksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
