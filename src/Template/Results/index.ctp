<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Result[]|\Cake\Collection\CollectionInterface $results
 */
?>

<div class="results index large-9 medium-8 columns content">
    <h3><?= __('Results') ?></h3>
    <table class="table" cellpadding="4" cellspacing="8">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col"><?= $this->Paginator->sort('number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('country') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('connect_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_time') ?></th>
                <th>Duration</th>
                <th scope="col"><?= $this->Paginator->sort('score') ?></th>
                <th scope="col">Recording</th>
                <th scope="col"><?= $this->Paginator->sort('added_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('added_on') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result): 
                $srt = new DateTime($result->start_time); 
                $end = new DateTime($result->end_time);
                $con = new DateTime($result->connect_time); 
                ?>
                    
            <tr>
                <td><?= (string)($result->job_processing_uid) . '_' . (string)($result->test_counter) . '_' . (string)($result->test_type_uid) ?></td>
                <td><?= h($result->number) ?></td>
                <td><?= h($result->country) ?></td>
                <td><?= $srt->format('Y-m-d H:i:s') ?></td>
                <td><?= $con->format('Y-m-d H:i:s') ?></td>
                <td><?= $end->format('Y-m-d H:i:s') ?></td>
                <td><?php 
                    echo ($end->diff($srt))->format('%H:%I:%S');  ?></td>
                <td><?= $this->Number->format($result->score) ?></td>
                <td><?= $this->Html->link('Listen', $result->url); ?></td>
                <td><?= $this->Number->format($result->added_by) ?></td>
                <td><?= h($result->added_on) ?></td>
                <td class="actions">
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $result->id], ['confirm' => __('Are you sure you want to delete # {0}?', $result->id)]) ?>
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


<!-- 
<i class='fas fa-file-audio' style='font-size:24px'></i>

 -->