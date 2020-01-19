<?= $this->Form->create($results, ['class' => 'form-inline', 'type' => 'post', 'url' => ['action' => 'index']]); ?>
<?= $this->Form->input('start_date', ['class' => 'form-control datepicker mx-5', 
    'name' => 'start', 
    'type' => 'date',
    'minYear' => '1990',
    'default' => date('d-m-Y')]); ?>
<?= $this->Form->input('end_date', ['class' => 'form-control datepicker mx-5', 
    'name' => 'end', 
    'type' => 'date',
    'minYear' => '1990',
    'default' => date('d-m-Y')]); ?>
<?= $this->Form->control('Go', ['class' => 'btn btn-default mx-5', 'type' => 'submit', 'value' => 'Hp']); ?>
<?= $this->Form->end; ?>