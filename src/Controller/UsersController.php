<?php
namespace App\Controller;

use App\Controller\AppController;

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

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {
        // $session = $this->getRequest()->getSession();
        // debug($this->Auth->user('admin'));
        
        $users = $this->paginate($this->Users
            ->find()
            ->where(['status <>' => 2]));

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
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    
    public function editSelf($id) {
        return $this->edit($id, false);
    }

    public function edit($id, $showAdmin = true) {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('showAdmin', $showAdmin);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        // $user_before_patch = $user;
        $this->Users->patchEntity($user, ['status' => 2]);  // Don't actually delete, just set status to 2...
        // $user_after_patch = $user;
        // debug($user_before_patch);
        // die($user_after_patch);
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
            // debug($this->request);
            // debug($this->Auth);
            $user = $this->Auth->identify();
            // debug($user);
            if ($user && $user['status'] == 1) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            // Handle bad login
            $this->Flash->error('Email or password incorrect! Please try again.');
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function isAuthorized($user) {
        if ($this->request->getParam('action') === 'edit') {
            return true;
        }
        return parent::isAuthorized($user);
    }
}