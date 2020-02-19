<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\Debugger;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function beforeFilter($event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['logout']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {        
        $this->paginate = [
            'contain' => ['Creators'], 'limit' => 30
        ];
        $users = $this->paginate($this->Users
            ->find()
            ->where(['Users.status <' => 2]));
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        // Invoked by the 'Add' button in the 'Add User' modal
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->created_by = $this->Auth->user('id');
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    
    public function editSelf($id) {
        // Ha! No, don't call edit() - will introduce complexity with redirect despite being more DRY.
        return $this->edit($id, false);
    }

    public function edit($id, $showAdmin = true) {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if (in_array($this->request->getMethod(), ['POST', 'PUT', 'PATCH'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['patch', 'post', 'delete']);
        $user = $this->Users->get($id);
        $this->Users->patchEntity($user, ['status' => 2]);  // Don't actually delete, just set status to 2...
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        }
        else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login() {
        $this->viewBuilder()->setLayout('default_login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            // Handle bad login
            $this->Flash->error('Email or password incorrect! Please try again.');
        }
    }

    public function search() {  // Search id, number and country for user-supplied string; value must begin with string 
        $str = $this->request->getData('search');
        $this->paginate = [
            'contain' => ['Creators'], 'limit' => 30
        ];
        $query = $this->Users
            ->find()
            ->where(['Users.status <>' => 2]);
        $query = $query
            ->where(['Users.id LIKE' => ($str . '%')], ['Users.id' => 'string'])
            ->orWhere(['Users.name LIKE' => ($str . '%')])
            ->orWhere(['Users.email LIKE' => ($str . '%')]);
        $users = $this->paginate($query);
        $this->set(compact('users'));
    }

    public function filter() {
        $this->paginate = [
            'contain' => ['Creators'], 'limit' => 30
        ];
        $type = (int)$this->request->getData('type');
        $query = $this->Users->find()
                ->where(['Users.status <' => 2]);
        if ($type < 2) {
            $query = $query
                ->where(['Users.status =' => $type]);
        }
        $users = $this->paginate($query);
        $this->set(compact('users'));
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function isAuthorized($user) {
        if ($this->request->getParam('action') === 'edit') {
            // Add condition that non-admin user can only edit own profile;
            // Test that non-admin user cannot access /users;
            return true;
        }
        return parent::isAuthorized($user);
    }
}
