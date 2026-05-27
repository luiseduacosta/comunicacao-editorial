<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pautas Model
 *
 * @property \App\Model\Table\ComentapautasTable&\Cake\ORM\Association\HasMany $Comentapautas
 * @property \App\Model\Table\MateriasTable&\Cake\ORM\Association\HasMany $Materias
 *
 * @method \App\Model\Entity\Pauta newEmptyEntity()
 * @method \App\Model\Entity\Pauta newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Pauta> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pauta get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Pauta findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Pauta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Pauta> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pauta|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Pauta saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Pauta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pauta>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pauta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pauta> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pauta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pauta>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pauta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pauta> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PautasTable extends Table
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

        $this->setTable('pautas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Comentapautas', [
            'foreignKey' => 'pauta_id',
        ]);
        $this->hasMany('Materias', [
            'foreignKey' => 'pauta_id',
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
            ->date('data')
            ->requirePresence('data', 'create')
            ->notEmptyDate('data');

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 256)
            ->allowEmptyString('titulo');

        $validator
            ->scalar('descricao')
            ->allowEmptyString('descricao');

        $validator
            ->scalar('anexos')
            ->maxLength('anexos', 500)
            ->allowEmptyString('anexos');

        $validator
            ->scalar('observacoes')
            ->maxLength('observacoes', 255)
            ->allowEmptyString('observacoes');

        $validator
            ->boolean('arquivar')
            ->notEmptyString('arquivar');

        $validator
            ->boolean('informandes')
            ->notEmptyString('informandes');

        return $validator;
    }
}
