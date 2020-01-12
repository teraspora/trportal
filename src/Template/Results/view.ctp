<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Result $result
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Result'), ['action' => 'edit', $result->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Result'), ['action' => 'delete', $result->id], ['confirm' => __('Are you sure you want to delete # {0}?', $result->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Results'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Result'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="results view large-9 medium-8 columns content">
    <h3><?= h($result->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($result->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number') ?></th>
            <td><?= h($result->number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Country') ?></th>
            <td><?= h($result->country) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Url') ?></th>
            <td><?= h($result->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Job Processing Id') ?></th>
            <td><?= $this->Number->format($result->job_processing_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Test Type Id') ?></th>
            <td><?= $this->Number->format($result->test_type_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Test Counter') ?></th>
            <td><?= $this->Number->format($result->test_counter) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Score') ?></th>
            <td><?= $this->Number->format($result->score) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Added By') ?></th>
            <td><?= $this->Number->format($result->added_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Time') ?></th>
            <td><?= h($result->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Time') ?></th>
            <td><?= h($result->end_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Connect Time') ?></th>
            <td><?= h($result->connect_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Added On') ?></th>
            <td><?= h($result->added_on) ?></td>
        </tr>
    </table>
</div>
