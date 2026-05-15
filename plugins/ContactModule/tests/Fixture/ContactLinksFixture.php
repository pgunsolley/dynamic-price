<?php
declare(strict_types=1);

namespace ContactManager\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContactLinksFixture
 */
class ContactLinksFixture extends TestFixture
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
                'url' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-05-11 18:00:39',
                'modified' => '2026-05-11 18:00:39',
            ],
        ];
        parent::init();
    }
}
