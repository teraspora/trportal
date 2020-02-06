<?= $this->Form->create($user, ['url' => ['action' => 'edit']]) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('email');
            if ($showAdmin) echo $this->Form->control('admin');
            echo $this->Form->control('password', ['empty' => true]);
            echo $this->Form->control('confirm_pw', ['empty' => true]);
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Update'), ['type' => 'submit', 'class' => 'btn btn-warning']) ?>
<?= $this->Form->end() ?>