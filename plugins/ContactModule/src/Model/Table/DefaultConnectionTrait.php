<?php
declare(strict_types=1);

namespace ContactModule\Model\Table;

use Cake\Core\Configure;

/**
 * Provides method to load default connection for ContactModule models
 */
trait DefaultConnectionTrait
{
    public static function defaultConnectionName(): string
    {
        return Configure::read('ContactModule.connection', 'default');
    }
}
