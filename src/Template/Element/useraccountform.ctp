<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('email');
            if ($showAdmin) echo $this->Form->control('admin');
            echo $this->Form->control('password');
            echo $this->Form->control('confirm_password');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Update')) ?>
<?= $this->Form->end() ?>