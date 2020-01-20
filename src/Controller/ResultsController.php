<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Results Controller
 *
 * @property \App\Model\Table\ResultsTable $Results
 *
 * @method \App\Model\Entity\Result[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ResultsController extends AppController {
    
    public function initialize() {
        parent::initialize();
    }

    // Helper function to pull out a date string from a DateTime-type object
    public function getDateStringFromObject($obj, $set_23_59 = false) {
        // Get YY-mm-dd from the json-type object in request data; add ' 23:59:59' if 2nd param true.
        return $obj['year'] . '-' . $obj['month'] . '-' . $obj['day'] . ($set_23_59 ? ' 23:59:59' : '');
    }

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
            $query = $this->Results
                ->find()
                ->where(['status =' => 1])
                ->andWhere(['start_time >=' => $srt])
                ->andWhere(['start_time <=' => $end]);
        }
        else {      // Method must be 'get' so display all (except with status == 2)
            $query = $this->Results
                ->find()
                ->where(['status =' => 1]);
        }
        $results = $this->paginate($query);
        $this->set(compact('results'));        
    }

    /**
     * View method
     *
     * @param string|null $id Result id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     $result = $this->Results->get($id, [
    //         'contain' => [],
    //     ]);

    //     $this->set('result', $result);
    // }

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
     * Delete method
     *
     * @param string|null $id Result id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id_str = null) {
        $this->request->allowMethod(['post', 'delete']);
        list($job_processing_uid, $test_type_uid, $test_counter) = array_map('intval', explode('_', $id_str));
        // eval(breakpoint());
        $result = $this->Results->get([$job_processing_uid, $test_type_uid, $test_counter]);
        $this->Results->patchEntity($result, ['status' => 2]);  // Don't actually delete, just set status to 2...
        // die($result);
        // debug($this->Results);
        if ($this->Results->save($result)) {
            $this->Flash->success(__('The result has been deleted.'));  // ...but tell user it's deleted
        } else {
            $this->Flash->error(__('The result could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function export() {
        $path = WWW_ROOT . 'files/results_export.csv';
        file_put_contents($path, 'THIS LINE WRITTEN BY EXPORT METHOD');
        $readout = file_get_contents($path);
        die($readout);
        $response = $this->response->withFile($path, ['download' => true]);
        $this->Flash->success(__('The file will be downloaded.'));
        return $response;
    }

    public function isAuthorized($user) {
        debug($user);
        return true;
    }


}
