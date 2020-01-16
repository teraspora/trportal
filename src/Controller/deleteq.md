# 'Record not found in table' error when using `get()` on table with composite primary key

I have a database with a table called `results`.   It has a composite primary key, consisting of 3 parts: `job_processing_uid`, `test_type_uid`, `test_counter`.

When I try to get a reference to a row by its primary key, I receive this error, despite these being the correct values and a row with these values existing in the table (as shown in the phpMyAdmin screenshot).

`Record not found in table "results" with primary key [3258637, 1, 1]`

My code (in my `ResultsController`) is:

```
public function delete($id_str = null) {
        $this->request->allowMethod(['post', 'delete']);
        list($job_processing_uid, $test_type_uid, $test_counter) =
            array_map('intval', explode('_', $id_str));

        $result = $this->Results->get([$job_processing_uid, $test_type_uid, 
            $test_counter]);
        // Don't actually delete, just set status to 2...
        $this->Results->patchEntity($result, ['status' => 2]); 
         
        if ($this->Results->save($result)) {
            $this->Flash->success(__('The result has been deleted.'));
        } else {
            $this->Flash->error(__('The result could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
```

It is this line:
`$result = $this->Results->get([$job_processing_uid, $test_type_uid, $test_counter]);` which is failing to retrieve the row and throwing the error.

Extra info:  the call `debug($this->Results);` prints

```
object(App\Model\Table\ResultsTable) {

    'registryAlias' => 'Results',
    'table' => 'results',
    'alias' => 'Results',
    'entityClass' => 'App\Model\Entity\Result',
    'associations' => [],
    'behaviors' => [],
    'defaultConnection' => 'default',
    'connectionName' => 'default'
}
```

I am not sure what could be wrong or how to debug this further.   Could someone point me in the right direction please? 
