<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Carros Model
 *
 * @property \App\Model\Table\ClientesTable&\Cake\ORM\Association\BelongsTo $Clientes
 * @property \App\Model\Table\RevisoesTable&\Cake\ORM\Association\HasMany $Revisoes
 *
 * @method \App\Model\Entity\Carro get($primaryKey, $options = [])
 * @method \App\Model\Entity\Carro newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Carro[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Carro|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Carro saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Carro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Carro[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Carro findOrCreate($search, callable $callback = null, $options = [])
 */
class CarrosTable extends Table
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

        $this->setTable('carros');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id',
        ]);
        $this->hasMany('Revisoes', [
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
            ->scalar('placa')
            ->maxLength('placa', 8)
            ->notEmpty('placa');

        $validator
            ->scalar('nome_carro')
            ->maxLength('nome_carro', 40)
            ->requirePresence('nome_carro', 'create')
            ->notEmpty('nome_carro');

        $validator
            ->scalar('cor_carro')
            ->maxLength('cor_carro', 25)
            ->requirePresence('cor_carro', 'create')
            ->notEmpty('cor_carro');

        $validator
            ->scalar('ano_carro')
            ->maxLength('ano_carro', 4)
            ->requirePresence('ano_carro', 'create')
            ->notEmpty('ano_carro');

        $validator
            ->scalar('marca_carro')
            ->maxLength('marca_carro', 255)
            ->notEmpty('marca_carro');

        $validator
            ->scalar('combustivel_carro')
            ->maxLength('combustivel_carro', 255)
            ->notEmpty('combustivel_carro');

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
        $rules->add($rules->existsIn(['cliente_id'], 'Clientes'));

        return $rules;
    }
}
