<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Results Controller
 *
 * @property \App\Model\Table\ResultsTable $Results
 *
 * @method \App\Model\Entity\Result[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ResultsController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {
        if ($this->request->is('post')) {       // Method must be 'post' so display by date range
            $start_date = $this->getDateStringFromObject($this->request->getData('start'), false);
            $end_date = $this->getDateStringFromObject($this->request->getData('end'), true);
            if (is_null($start_date)) {
                $srt = new Time('20 years ago');
                if (is_null($end_date)) {
                    $end = Time::now();
                }
                else {
                    $end = new Time($end_date);
                }
            }
            else {
                $srt = new Time($start_date);
                if (is_null($end_date)) {
                    $end = Time::now();
                }
                else {
                    $end = new Time($end_date);
                }
            }
            debug($srt);
            debug($end);            
            $query = $this->Results
                ->find()
                ->where(['start_time >=' => $srt])
                ->andWhere(['start_time <=' => $end]);
            // debug($query);
            $results = $this->paginate($query);
        }
        else {      // Method must be 'get' so display all
            $results = $this->paginate($this->Results);
        }
        $this->set(compact('results'));        
    }

    public function getDateStringFromObject($obj, $set_23_59 = false) {
        // Get YYmmdd from the json-type object in request data; add ' 23:59:59' if 2nd param true.
        return $obj['year'] . '-' . $obj['month'] . '-' . $obj['day'] . ($set_23_59 ? ' 23:59:59' : '');
    }

    /**
     * View method
     *
     * @param string|null $id Result id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $result = $this->Results->get($id, [
            'contain' => [],
        ]);

        $this->set('result', $result);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $result = $this->Results->newEntity();
    //     if ($this->request->is('post')) {
    //         $result = $this->Results->patchEntity($result, $this->request->getData());
    //         if ($this->Results->save($result)) {
    //             $this->Flash->success(__('The result has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The result could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('result'));
    // }

    /**
     * Edit method
     *
     * @param string|null $id Result id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
    //     $result = $this->Results->get($id, [
    //         'contain' => [],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $result = $this->Results->patchEntity($result, $this->request->getData());
    //         if ($this->Results->save($result)) {
    //             $this->Flash->success(__('The result has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The result could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('result'));
    // }

    /**
     * Delete method
     *
     * @param string|null $id Result id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $result = $this->Results->get($id);
        if ($this->Results->delete($result)) {
            $this->Flash->success(__('The result has been deleted.'));
        } else {
            $this->Flash->error(__('The result could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
