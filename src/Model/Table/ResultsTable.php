<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Results Model
 *
 * @method \App\Model\Entity\Result get($primaryKey, $options = [])
 * @method \App\Model\Entity\Result newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Result[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Result|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Result saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Result patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Result[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Result findOrCreate($search, callable $callback = null, $options = [])
 */
class ResultsTable extends Table
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

        $this->setTable('results');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->nonNegativeInteger('job_processing_uid')
            ->allowEmptyString('job_processing_uid', null, 'create');

        $validator
            ->nonNegativeInteger('test_type_uid')
            ->allowEmptyString('test_type_uid', null, 'create');

        $validator
            ->nonNegativeInteger('test_counter')
            ->allowEmptyString('test_counter', null, 'create');

        $validator
            ->scalar('number')
            ->maxLength('number', 20)
            ->allowEmptyString('number');

        $validator
            ->scalar('country')
            ->maxLength('country', 100)
            ->allowEmptyString('country');

        $validator
            ->dateTime('start_time')
            ->allowEmptyDateTime('start_time');

        $validator
            ->dateTime('end_time')
            ->allowEmptyDateTime('end_time');

        $validator
            ->dateTime('connect_time')
            ->allowEmptyDateTime('connect_time');

        $validator
            ->numeric('score')
            ->greaterThanOrEqual('score', 0)
            ->allowEmptyString('score');

        $validator
            ->scalar('url')
            ->maxLength('url', 1024)
            ->allowEmptyString('url');

        $validator
            ->nonNegativeInteger('added_by')
            ->allowEmptyString('added_by');

        $validator
            ->dateTime('added_on')
            ->allowEmptyDateTime('added_on');

        return $validator;
    }
}
