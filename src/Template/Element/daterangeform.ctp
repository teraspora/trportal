<?= $this->Form->create($results, ['class' => 'form-inline', 'type' => 'post', 'url' => ['action' => 'index']]); ?>
<?= '<div class="form-group">' ?>
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
<?= $this->Form->control(__('Go'), ['class' => 'btn btn-info mx-5', 'type' => 'submit']); ?>
<?= '</div>' ?>
<?= $this->Form->end; ?>
