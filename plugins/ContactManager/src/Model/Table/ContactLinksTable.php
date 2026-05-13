<?php
declare(strict_types=1);

namespace ContactManager\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContactLinks Model
 *
 * @property \ContactManager\Model\Table\ContactsTable&\Cake\ORM\Association\BelongsTo $Contacts
 *
 * @method \ContactManager\Model\Entity\ContactLink newEmptyEntity()
 * @method \ContactManager\Model\Entity\ContactLink newEntity(array $data, array $options = [])
 * @method array<\ContactManager\Model\Entity\ContactLink> newEntities(array $data, array $options = [])
 * @method \ContactManager\Model\Entity\ContactLink get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \ContactManager\Model\Entity\ContactLink findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \ContactManager\Model\Entity\ContactLink patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\ContactManager\Model\Entity\ContactLink> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ContactManager\Model\Entity\ContactLink|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \ContactManager\Model\Entity\ContactLink saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\ContactManager\Model\Entity\ContactLink>|\Cake\Datasource\ResultSetInterface<\ContactManager\Model\Entity\ContactLink>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\ContactManager\Model\Entity\ContactLink>|\Cake\Datasource\ResultSetInterface<\ContactManager\Model\Entity\ContactLink> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\ContactManager\Model\Entity\ContactLink>|\Cake\Datasource\ResultSetInterface<\ContactManager\Model\Entity\ContactLink>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\ContactManager\Model\Entity\ContactLink>|\Cake\Datasource\ResultSetInterface<\ContactManager\Model\Entity\ContactLink> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContactLinksTable extends Table
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

        $this->setTable('contact_links');
        $this->setDisplayField('label');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Contacts', [
            'foreignKey' => 'contact_id',
            'joinType' => 'INNER',
            'className' => 'ContactManager.Contacts',
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
            ->nonNegativeInteger('contact_id')
            ->notEmptyString('contact_id');

        $validator
            ->scalar('label')
            ->maxLength('label', 255)
            ->requirePresence('label', 'create')
            ->notEmptyString('label');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['contact_id'], 'Contacts'), ['errorField' => 'contact_id']);

        return $rules;
    }
}
