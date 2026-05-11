<?php
declare(strict_types=1);

namespace ContactManager\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContactEmailsFixture
 */
class ContactEmailsFixture extends TestFixture
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
                'contact_id' => 1,
                'label' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-05-11 18:00:29',
                'modified' => '2026-05-11 18:00:29',
            ],
        ];
        parent::init();
    }
}
