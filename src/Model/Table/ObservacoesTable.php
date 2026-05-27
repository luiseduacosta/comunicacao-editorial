<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Observacoes Model
 *
 * @property \App\Model\Table\MateriasTable&\Cake\ORM\Association\BelongsTo $Materias
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Observaco newEmptyEntity()
 * @method \App\Model\Entity\Observaco newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Observaco> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Observaco get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Observaco findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Observaco patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Observaco> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Observaco|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Observaco saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Observaco>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Observaco>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Observaco>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Observaco> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Observaco>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Observaco>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Observaco>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Observaco> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ObservacoesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('observacoes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Materias', [
            'foreignKey' => 'materia_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->integer('materia_id')
            ->notEmptyString('materia_id');

        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id');

        $validator
            ->scalar('observacao')
            ->requirePresence('observacao', 'create')
            ->notEmptyString('observacao');

        $validator
            ->scalar('autor')
            ->maxLength('autor', 50)
            ->allowEmptyString('autor');

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
        $rules->add($rules->existsIn(['materia_id'], 'Materias'), ['errorField' => 'materia_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
