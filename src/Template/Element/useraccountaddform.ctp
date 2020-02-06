<?= $this->Form->create($user, ['url' => ['action' => 'add']]) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('email');
            echo $this->Form->control('status');    
            echo $this->Form->control('password', ['empty' => true]);
            echo $this->Form->control('confirm_pw', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Add'), ['type' => 'submit', 'class' => 'btn btn-warning']) ?>
<?= $this->Form->end() ?>