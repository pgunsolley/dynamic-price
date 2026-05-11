<?php
declare(strict_types=1);

namespace ContactManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contact Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_initial
 * @property string $last_name
 * @property string|null $notes
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \ContactManager\Model\Entity\ContactEmail[] $contact_emails
 * @property \ContactManager\Model\Entity\ContactLink[] $contact_links
 * @property \ContactManager\Model\Entity\ContactPhone[] $contact_phones
 */
class Contact extends Entity
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
        'first_name' => true,
        'middle_initial' => true,
        'last_name' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'contact_emails' => true,
        'contact_links' => true,
        'contact_phones' => true,
    ];
}
