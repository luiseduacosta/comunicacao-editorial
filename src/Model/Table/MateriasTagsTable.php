<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MateriasTags Model
 *
 * @property \App\Model\Table\MateriasTable&\Cake\ORM\Association\BelongsTo $Materias
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\MateriasTag newEmptyEntity()
 * @method \App\Model\Entity\MateriasTag newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\MateriasTag> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MateriasTag get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\MateriasTag findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\MateriasTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\MateriasTag> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MateriasTag|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\MateriasTag saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\MateriasTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MateriasTag>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MateriasTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MateriasTag> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MateriasTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MateriasTag>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MateriasTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MateriasTag> deleteManyOrFail(iterable $entities, array $options = [])
 */
class MateriasTagsTable extends Table
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

        $this->setTable('materias_tags');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Materias', [
            'foreignKey' => 'materia_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
            'joinType' => 'INNER',
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
            ->integer('tag_id')
            ->notEmptyString('tag_id');

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
        $rules->add($rules->isUnique(['materia_id', 'tag_id']), ['errorField' => 'materia_id', 'message' => __('This combination of materia_id and tag_id already exists')]);
        $rules->add($rules->existsIn(['materia_id'], 'Materias'), ['errorField' => 'materia_id']);
        $rules->add($rules->existsIn(['tag_id'], 'Tags'), ['errorField' => 'tag_id']);

        return $rules;
    }
}
