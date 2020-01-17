<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Result[]|\Cake\Collection\CollectionInterface $results
 */
?>

<?php
$this->start('topbar');

        echo $this->Form->create($results, ['class' => 'form-inline', 'type' => 'post', 'url' => ['action' => 'index']]);
        echo $this->Form->input('start_date', ['class' => 'form-control datepicker mx-5', 
            'name' => 'start', 
            'type' => 'date',
            'minYear' => '1990',
            'default' => date('d-m-Y')]);
        echo $this->Form->input('end_date', ['class' => 'form-control datepicker mx-5', 
            'name' => 'end', 
            'type' => 'date',
            'minYear' => '1990',
            'default' => date('d-m-Y')]);
        echo $this->Form->control('Go', ['class' => 'btn btn-default mx-5', 'type' => 'submit',
            'value' => 'Hp']);
        echo $this->Form->end;

        echo $this->Form->create(null, ['class' => 'form-inline', 'type' => 'file', 'url' => ['action' => 'import']]);
        echo '<button>' . $this->Html->link('Export', ['action' => 'export']) . '</button>';
        echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#uploadModal">Import</button>';
        echo $this->Form->control('search', ['class' => 'form-control mx-5']);
        echo $this->Form->end();

$this->end();
?>

<div class="results index large-9 medium-8 columns content">
    <table class="table table-striped" cellpadding="4" cellspacing="8">
        <thead class="thead-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id_str', 'ID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number', 'Number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('country', 'Country') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_time', 'Start time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('connect_time', 'Connect time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_time', 'End time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('duration', 'Duration') ?></th>
                <th scope="col"><?= $this->Paginator->sort('score', 'Score') ?></th>
                <th scope="col">Recording</th>
                <th scope="col"><?= $this->Paginator->sort('added_by', 'Added By') ?></th>
                <th scope="col"><?= $this->Paginator->sort('added_on', 'Added On') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
                use Cake\I18n\Time;
                foreach ($results as $result): 
                    $srt = new Time($result->start_time); 
                    $end = new Time($result->end_time);
                    $con = new Time($result->connect_time); 
            ?>
                    
            <tr>
                <td><?= h($result->id_str) ?></td>
                <td><?= h($result->number) ?></td>
                <td><?= h($result->country) ?></td>
                <td><?= $srt->format('Y-m-d H:i:s') ?></td>
                <td><?= $con->format('Y-m-d H:i:s') ?></td>
                <td><?= $end->format('Y-m-d H:i:s') ?></td>
                <td><?= h($result->duration) ?></td>
                <td><?= $this->Number->format($result->score) ?></td>
                <td><?= $this->Html->link('Listen', $result->url); ?></td>
                <td><?= $this->Number->format($result->added_by) ?></td>
                <td><?= h($result->added_on) ?></td>
                <td class="actions">
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $result->id_str], ['confirm' => __('Are you sure you want to delete record?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>

<div id="uploadModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">File upload form</h4>
      </div>
      <div class="modal-body">
        <!-- Form -->
        <form method='post' action='' enctype="multipart/form-data">
          Please choose a file to import <input type='file' name='file' id='file' class='form-control' ><br>
          <input type='submit' class='btn btn-info' value='Upload' id='btn_upload'>
        </form>

        <!-- Preview-->
        <div id='preview'></div>
      </div>
 
    </div>

  </div>
</div>