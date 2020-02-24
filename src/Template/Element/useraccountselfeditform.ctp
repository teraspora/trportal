<?= $this->Form->create(null, ['type' => 'post', 'idPrefix' => 'self-edit', 'url' => ['action' => 'editSelf']]) ?>
    <fieldset id="user-self-edit">
        <legend><?= __('Edit Your Profile') ?></legend>  
        <?= $this->Form->control('name'); ?>
        <?= $this->Form->control('email'); ?>
        <?= $this->Form->input('status', ['type' => 'select', 'label' => false, 'options' => ['Inactive', 'Active'], 'value' => 1]); ?>
        <?= $this->Form->control('pwd', ['type' => 'password', 'label' => 'Password', 'value' => '', 'autocomplete' => 'off']); ?>
        <?= $this->Form->control('confirm_password', ['type' => 'password', 'value' => '', 'autocomplete' => 'off']); ?>
    </fieldset>
    <?= $this->Form->button(__('Update'), ['type' => 'submit', 'class' => 'btn btn-info']) ?>
<?= $this->Form->end() ?>