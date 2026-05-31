<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Materias Model
 *
 * @property \App\Model\Table\PautasTable&\Cake\ORM\Association\BelongsTo $Pautas
 * @property \App\Model\Table\ObservacoesTable&\Cake\ORM\Association\HasMany $Observacoes
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \App\Model\Entity\Materia newEmptyEntity()
 * @method \App\Model\Entity\Materia newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Materia> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Materia get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Materia findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Materia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Materia> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Materia|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Materia saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Materia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Materia>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Materia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Materia> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Materia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Materia>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Materia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Materia> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MateriasTable extends Table
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

        $this->setTable('materias');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pautas', [
            'foreignKey' => 'pauta_id',
        ]);
        $this->hasMany('Observacoes', [
            'foreignKey' => 'materia_id',
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'materia_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'materias_tags',
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
            ->integer('pauta_id')
            ->allowEmptyString('pauta_id');

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->requirePresence('titulo', 'create')
            ->notEmptyString('titulo');

        $validator
            ->scalar('conteudo')
            ->requirePresence('conteudo', 'create')
            ->notEmptyString('conteudo');

        $validator
            ->boolean('arquivar')
            ->allowEmptyString('arquivar');

        $validator
            ->boolean('informandes')
            ->allowEmptyString('informandes');

        $validator
            ->boolean('publicar')
            ->allowEmptyString('publicar');

        $validator
            ->scalar('anexos')
            ->allowEmptyString('anexos');

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
        $rules->add($rules->existsIn(['pauta_id'], 'Pautas'), ['errorField' => 'pauta_id']);

        return $rules;
    }
}
