<?php
declare(strict_types=1);

namespace ContactManager\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contacts Model
 *
 * @property \ContactManager\Model\Table\ContactEmailsTable&\Cake\ORM\Association\HasMany $ContactEmails
 * @property \ContactManager\Model\Table\ContactLinksTable&\Cake\ORM\Association\HasMany $ContactLinks
 * @property \ContactManager\Model\Table\ContactPhonesTable&\Cake\ORM\Association\HasMany $ContactPhones
 *
 * @method \ContactManager\Model\Entity\Contact newEmptyEntity()
 * @method \ContactManager\Model\Entity\Contact newEntity(array $data, array $options = [])
 * @method array<\ContactManager\Model\Entity\Contact> newEntities(array $data, array $options = [])
 * @method \ContactManager\Model\Entity\Contact get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \ContactManager\Model\Entity\Contact findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \ContactManager\Model\Entity\Contact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\ContactManager\Model\Entity\Contact> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ContactManager\Model\Entity\Contact|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \ContactManager\Model\Entity\Contact saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\ContactManager\Model\Entity\Contact>|\Cake\Datasource\ResultSetInterface<\ContactManager\Model\Entity\Contact>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\ContactManager\Model\Entity\Contact>|\Cake\Datasource\ResultSetInterface<\ContactManager\Model\Entity\Contact> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\ContactManager\Model\Entity\Contact>|\Cake\Datasource\ResultSetInterface<\ContactManager\Model\Entity\Contact>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\ContactManager\Model\Entity\Contact>|\Cake\Datasource\ResultSetInterface<\ContactManager\Model\Entity\Contact> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContactsTable extends Table
{
    use DefaultConnectionTrait;

    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('contacts');
        $this->setDisplayField('first_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ContactEmails', [
            'foreignKey' => 'contact_id',
            'className' => 'ContactManager.ContactEmails',
        ]);
        $this->hasMany('ContactLinks', [
            'foreignKey' => 'contact_id',
            'className' => 'ContactManager.ContactLinks',
        ]);
        $this->hasMany('ContactPhones', [
            'foreignKey' => 'contact_id',
            'className' => 'ContactManager.ContactPhones',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('middle_initial')
            ->maxLength('middle_initial', 1)
            ->allowEmptyString('middle_initial');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->scalar('notes')
            ->maxLength('notes', 255)
            ->allowEmptyString('notes');

        return $validator;
    }
}
