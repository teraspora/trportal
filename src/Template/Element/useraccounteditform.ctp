<?= $this->Form->create($users, ['type' => 'post', 'url' => ['action' => 'edit']]) ?>
    <fieldset id="user-edit">
        <legend><?= __('Edit User') ?></legend>
        <?= $this->Form->control('name'); ?>
        <?= $this->Form->control('email'); ?>
        <div class="input admin">
            <?= $this->Form->label('admin', 'Admin'); ?>
            <?= $this->Form->checkbox('admin', ['id' => 'admin']); ?>
        </div>
        <?= $this->Form->input('status', ['type' => 'select', 'label' => false, 'options' => ['Inactive', 'Active'], 'value' => 1]); ?>
        <?= $this->Form->control('password', ['type' => 'password', 'value' => '', 'autocomplete' => 'off']); ?>
        <?= $this->Form->control('confirm_password', ['type' => 'password', 'value' => '', 'autocomplete' => 'off']); ?>
    </fieldset>
    <?= $this->Form->button(__('Update'), ['type' => 'submit', 'class' => 'btn btn-info']) ?>
<?= $this->Form->end() ?>