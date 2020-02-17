<?= $this->Form->create() ?>
    <fieldset id="user-add">
        <legend><?= __('Add User') ?></legend>
        <?= $this->Form->control('name'); ?>
        <?= $this->Form->control('email'); ?>
        <div class="input admin">
            <?= $this->Form->label('admin', 'Admin'); ?>
            <?= $this->Form->checkbox('admin', ['id' => 'admin']); ?>
        </div>
        <?= $this->Form->input('status', ['type' => 'select', 'label' => false, 'options' => ['Inactive', 'Active'], 'value' => 1]); ?>
        <?= $this->Form->control('password', ['type'=>'password', 'value'=>'', 'autocomplete'=>'off']); ?>
        <?= $this->Form->control('confirm_password', ['type'=>'password', 'value'=>'', 'autocomplete'=>'off']); ?>
    </fieldset>
    <?= $this->Form->button(__('Add'), ['type' => 'submit', 'class' => 'btn btn-warning']) ?>
<?= $this->Form->end() ?>