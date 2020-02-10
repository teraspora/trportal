<?= $this->Form->create($users, ['class' => 'form-inline', 'type' => 'post', 'action' => 'filter']); ?>

<?= '<div class="form-group">' ?>
<?= $this->Form->input('type', ['type' => 'select', 'label' => false, 'options' => ['Inactive', 'Active', 'All'], 'value' => 2, 'onchange' => 'submit();']); ?>
<?= '</div>' ?>
<?= $this->Form->end(); ?>
