<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateContacts extends BaseMigration
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
            ->table('contacts')
            ->addColumn('first_name', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('middle_initial', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 1,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('notes', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
