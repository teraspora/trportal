<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Error\Debugger;

/**
 * Results Controller
 *
 * @property \App\Model\Table\ResultsTable $Results
 *
 * @method \App\Model\Entity\Result[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ResultsController extends AppController {
    
    public $test_bool = true;
    public function initialize() {
        parent::initialize();
    }

    // Helper function to pull out a date string from a DateTime-type object
    public function getDateStringFromObject($obj, $set_23_59 = false) {
        // Get YY-mm-dd from the json-type object in request data; add ' 23:59:59' if 2nd param true.
        return $obj['year'] . '-' . $obj['month'] . '-' . $obj['day'] . ($set_23_59 ? ' 23:59:59' : '');
    }

    // Helper function to pull out a the primary key components from an idstr
    // public function getPrimaryKeyFromIdString($idstr) {
        

    //     return [$jpid, $ttid, $tc];
    // }

/**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {
        if ($this->request->is('put')) {       // if method is 'put', display by date range
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
        else {      // If method is 'get', display all (except with status == 2)
            $query = $this->Results
                ->find()
                ->where(['status =' => 1]);
        }
        $results = $this->paginate($query);
        $this->set(compact('results'));        
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
     * Delete method
     *
     * @param string|null $id Result id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id_str = null) {
        $this->request->allowMethod(['post', 'delete']);
        list($job_processing_uid, $test_type_uid, $test_counter) = array_map('intval', explode('_', $id_str));
        $result = $this->Results->get([$job_processing_uid, $test_type_uid, $test_counter]);
        $this->Results->patchEntity($result, ['status' => 2]);  // Don't actually delete, just set status to 2...
        if ($this->Results->save($result)) {
            $this->Flash->success(__('The result has been deleted.'));  // ...but tell user it's deleted
        } else {
            $this->Flash->error(__('The result could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function export() {
        $this->viewBuilder()->setLayout('');
        $this->response->download("results_export.csv");
        $data = $this->Results->find('all')
                    ->where(['status =' => 2]); // 2 for debugging, 1 for production!
        $this->set(compact('data'));
        $this->layout = 'ajax';
        return;
    }

    public function search() {  // Search id, number and country for user-supplied string; value must begin with string 
        $str = $this->request->getData('search');
        $query = $this->Results
            ->find()
            ->where(['status <>' => 2]);
        $query = $query
            ->where(['country LIKE' => ($str . '%')])
            ->orWhere(['job_processing_uid LIKE' => ($str . '%')], ['job_processing_uid' => 'string'])
            ->orWhere(['number LIKE' => ($str . '%')]);
        $results = $this->paginate($query);
        $this->set(compact('results'));
    }

    public function isAuthorized($user) {
        return true;
    }

    public function getCsvErrors($row) {
        // $this->$test_bool = !$this->$test_bool;
        // return $this->$test_bool;
        return '';

    }

    public function import() {
        $rows = [];
        $file = $this->request->getData('uploaded_file');
        if (!empty($file['name'])) {
            $uploadPath = 'uploads/files/';
            $uploadFile = $uploadPath . $file['name'];

            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $handle = fopen($uploadFile, 'r');
                // Get first line and ignore it (it should be column headings)
                $line = fgetcsv($handle);
                // Now get the rest and process them
                while(! feof($handle)) {
                    $line = fgetcsv($handle);
                    array_push($rows, $line);
                }
                fclose($handle);

                foreach ($rows as $row) {
                    // Extract the three primary key fields from the id
                    list($job_processing_uid, $test_type_uid, $test_counter) = array_map('intval', explode('_', $row[0]));
                    $number = $row[1];
                    $country = $row[2];
                    $start_time = $row[3];
                    $connect_time = $row[4];
                    $end_time = $row[5];
                    $score = floatval($row[6]);
                    $url = $row[7];                  
                    // Construct an associative array in the correct format for saving in database;
                    // Note that the `added_on` field is set by a MySql TRIGGER.
                    $row_data = [
                        'job_processing_uid' => $job_processing_uid,
                        'test_type_uid' => $test_type_uid,
                        'test_counter' => $test_counter,
                        'number' => $number,
                        'country' => $country,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'connect_time' => $connect_time,
                        'score' => $score,
                        'url' => $url,
                        'added_by' => $this->Auth->user('id'),     // this user
                        'status' => 1,
                    ];
                    
                    $new_result = $this->Results->newEntity();
                    $this->Results->patchEntity($new_result, $row_data);
                    // If result with same primary key exists in database, it will be updated
                    if (!$this->Results->save($new_result)) {
                        Debugger::dump($row_data . "NOT saved.");
                    }
                }
                return $this->redirect(['action' => 'index']);
            }
            else {
                // Inform user file could not be uploaded?  Try to diagnose cause?
            }
        }
        else {
            // file name empty - handle this (why? how?)
        }
        return $this->redirect(['action' => 'index']);  // We shouldn't get here!
    }
}   // End class ResultsController
