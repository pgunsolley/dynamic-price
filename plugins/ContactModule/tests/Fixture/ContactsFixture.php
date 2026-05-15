<?php
declare(strict_types=1);

namespace ContactManager\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContactsFixture
 */
class ContactsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'first_name' => 'Lorem ipsum dolor sit amet',
                'middle_initial' => 'L',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'notes' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-05-11 18:00:23',
                'modified' => '2026-05-11 18:00:23',
            ],
        ];
        parent::init();
    }
}
