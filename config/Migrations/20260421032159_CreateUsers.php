<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateUsers extends BaseMigration
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
            ->table('users')
            ->addColumn('email', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('email_verified', 'boolean', [
                'default' => false,
                'null' => false,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
