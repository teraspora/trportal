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
        // $this->setDisplayField('id');
        $this->setPrimaryKey(['job_processing_uid', 'test_type_uid', 'test_counter']);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */

    /**
    Validation: see API docs at https://api.cakephp.org/3.8/namespace-Cake.Validation.html
    Notes: `Cake\Validation\Validation\isScalar()` tests a passed value; this method will return `true` 
    for integers, floats, strings and booleans, and `false` for arrays, objects, resources and nulls.
    
    Results can only be added by importing a csv file, and all fields in each row of this file must be populated.   `added_on`, `added_by` and `status` will be set later...(in the controller or model??)

    Add appropriate error messages then (listed in the spec).

    */

    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('job_processing_uid');

        $validator
            ->nonNegativeInteger('test_type_uid');

        $validator
            ->nonNegativeInteger('test_counter');

        $validator
            ->scalar('number')
            ->maxLength('number', 20);

        $validator
            ->scalar('country')
            ->maxLength('country', 100);

        $validator
            ->dateTime('start_time');

        $validator
            ->dateTime('end_time');

        $validator
            ->dateTime('connect_time');

        $validator
            ->numeric('score')
            ->greaterThanOrEqual('score', 0)
            ->lessThanOrEqual('score', 4.50);

        $validator
            ->scalar('url')
            ->maxLength('url', 1024);

        $validator
            ->nonNegativeInteger('added_by')    
            ->allowEmptyString('added_by');         // This will be set by the ORM

        $validator
            ->dateTime('added_on')              
            ->allowEmptyDateTime('added_on');       // This will be set by the database layer

        return $validator;
    }
}
