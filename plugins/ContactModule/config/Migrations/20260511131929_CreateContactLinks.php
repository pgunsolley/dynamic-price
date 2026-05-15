<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateContactLinks extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $this
            ->table('contact_links')
            ->addColumn('contact_id', 'integer', [
                'default' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('label', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
