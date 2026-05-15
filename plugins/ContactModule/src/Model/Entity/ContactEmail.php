<?php
declare(strict_types=1);

namespace ContactModule\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContactEmail Entity
 *
 * @property int $id
 * @property int $contact_id
 * @property string $label
 * @property string $email
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \ContactModule\Model\Entity\Contact $contact
 */
class ContactEmail extends Entity
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
        'contact_id' => true,
        'label' => true,
        'email' => true,
        'created' => true,
        'modified' => true,
        'contact' => true,
    ];
}
