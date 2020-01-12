<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Result $result
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Results'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="results form large-9 medium-8 columns content">
    <?= $this->Form->create($result) ?>
    <fieldset>
        <legend><?= __('Add Result') ?></legend>
        <?php
            echo $this->Form->control('job_processing_uid');
            echo $this->Form->control('test_type_uid');
            echo $this->Form->control('test_counter');
            echo $this->Form->control('number');
            echo $this->Form->control('country');
            echo $this->Form->control('start_time', ['empty' => true]);
            echo $this->Form->control('end_time', ['empty' => true]);
            echo $this->Form->control('connect_time', ['empty' => true]);
            echo $this->Form->control('score');
            echo $this->Form->control('url');
            echo $this->Form->control('added_by');
            echo $this->Form->control('added_on', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
