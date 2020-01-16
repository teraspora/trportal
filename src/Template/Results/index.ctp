<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Result[]|\Cake\Collection\CollectionInterface $results
 */
?>

<?php

$this->start('topbar');
        echo $this->Form->create($results, ['class' => 'form-inline', 'type' => 'post', 'url' => ['action' => 'index']]);
        echo '<div class="form-group">';
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
        echo '</div>';
        echo '<button>' . $this->Html->link('Export', ['action' => 'export']) . '</button>';
        echo '<button>Import</button>';
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

<!-- <script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
  crossorigin="anonymous">
</script>
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $(function() {
            $('.datepicker').datepicker();
        });
    });    
</script> -->

<!-- 
<i class='fas fa-file-audio' style='font-size:24px'></i>

 -->