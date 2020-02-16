<?= $this->Form->create($results, ['class' => 'form-inline', 'action' => 'search']) ?>
<?= $this->Form->input('search', ['label' => '', 'placeholder' => 'Search...', 'class' => 'form-control-lg mx-5', 'onchange' => 'submit();']) ?>
<?= $this->Form->end() ?>