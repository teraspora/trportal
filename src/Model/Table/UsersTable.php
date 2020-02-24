<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->belongsTo('Creators')
            ->setClassName('Users')
            ->setForeignKey('created_by');
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_on' => 'new'
                ]
            ]
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
            ->scalar('name')
            ->maxLength('name', 128)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', 'update');

        $validator
            ->email('email')
            ->maxLength('email', 512)
            ->requirePresence('email', 'create')
            ->allowEmptyString('email', 'update')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->boolean('admin')
            ->requirePresence('admin', 'create')
            ->allowEmptyString('admin', 'update');

        $validator
            ->scalar('pwd')
            ->maxLength('pwd', 128)
            ->requirePresence('pwd', 'create')
            ->allowEmptyString('pwd', 'update');

        $validator
            ->scalar('confirm_password')
            ->maxLength('confirm_password', 128)
            ->requirePresence('confirm_password', 'create')
            ->allowEmptyString('confirm_password', 'update');

        $validator
            ->nonNegativeInteger('status')
            ->requirePresence('status', 'create')
            ->allowEmptyString('status', 'update');

        $validator->add('pwd', 'length', ['rule' => ['lengthBetween', 8, 128]]);
        $validator->add('confirm_password', 'no-misspelling', [
            'rule' => ['compareWith', 'pwd'],
            'message' => 'Passwords are not equal',
        ]);
        $validator->add('pwd', 'custom', [
            'rule' => 'validatePasswordStrength',
            'message' => 'Password must contain >= 1 digit and >= 1 special character from "()*!_-$%". '
        ]);
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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    public function validatePasswordStrength($pw) {
        // Password must contain at least 1 digit and 1 special character from "()*!_-$%".
        $chars = '()*!_-$%';
        $digits = '0123456789';
        return is_string($pw) 
            && strlen($pw) > 7
            && similar_text($chars, $pw)
            && similar_text($digits, $pw);
    }

    // public function beforeSave($options = []) {
    //     if (!empty($this->data[$this->alias]['pwd'])) {
    //         $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['pwd']);
    //     }
    //     return true;
    // }
}

