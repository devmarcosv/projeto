<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Revisoes Model
 *
 * @property \App\Model\Table\CarrosTable&\Cake\ORM\Association\BelongsTo $Carros
 *
 * @method \App\Model\Entity\Reviso get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reviso newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Reviso[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reviso|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reviso saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reviso patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reviso[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reviso findOrCreate($search, callable $callback = null, $options = [])
 */
class RevisoesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('revisoes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Carros', [
            'foreignKey' => 'carro_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->requirePresence('data_revisao', 'create')
            ->notEmpty('data_revisao');

        $validator
            ->scalar('descricao_revisao')
            ->requirePresence('descricao_revisao', 'create')
            ->notEmpty('descricao_revisao');

        $validator
            ->numeric('valor_revisao')
            ->requirePresence('valor_revisao', 'create')
            ->notEmpty('valor_revisao');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['carro_id'], 'Carros'));

        return $rules;
    }
}
