<?= $this->Form->create($users, ['class' => 'form-inline', 'action' => 'search']); ?>
<?= $this->Form->input('search', ['label' => false, 'placeholder' => 'Search...', 'class' => 'form-control mx-5', 'onchange' => 'submit();']) ?>
<?= $this->Form->end() ?>
