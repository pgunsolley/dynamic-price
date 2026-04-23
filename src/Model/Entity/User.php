<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Datasource\Exception\MissingPropertyException;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property bool $email_verified
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'email' => true,
        'password' => true,
        'email_verified' => true,
        'created' => true,
        'modified' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'password',
    ];

    protected function _setPassword(string $unhashedValue): string
    {
        return (new DefaultPasswordHasher())->hash($unhashedValue);
    }

    public function checkPassword(string $unhashedValue): bool
    {
        $password = $this->get('password');

        if (!$password) {
            throw new MissingPropertyException('"password" is missing on User');
        }

        return (new DefaultPasswordHasher())->check($unhashedValue, $password);
    }
}
