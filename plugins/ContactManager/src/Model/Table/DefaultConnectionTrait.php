<?php
declare(strict_types=1);

namespace ContactManager\Model\Table;

use Cake\Core\Configure;

/**
 * Provides method to load default connection for ContactManager models
 */
trait DefaultConnectionTrait
{
    public static function defaultConnectionName(): string
    {
        return Configure::read('ContactManager.connection', 'default');
    }
}
