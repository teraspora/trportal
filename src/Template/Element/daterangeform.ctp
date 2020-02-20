<?= $this->Form->create($results, ['class' => 'form-inline', 'type' => 'post', 'url' => ['action' => 'index']]); ?>
<?= '<div class="form-group date-pickers">' ?>
<?= $this->Form->input('start_date', ['class' => 'form-control datepicker mx-5', 'value' => $start_date, 
    'name' => 'start', 
    'type' => 'date',
    'minYear' => '1990',
    'default' => date('d-m-Y')]); ?>
<?= $this->Form->input('end_date', ['class' => 'form-control datepicker mx-5', 'value' => $end_date,
    'name' => 'end', 
    'type' => 'date',
    'minYear' => '1990',
    'default' => date('d-m-Y')]); ?>
<?= $this->Form->control(__('Go'), ['class' => 'btn btn-info btn-xs mx-5', 'type' => 'submit']); ?>
<?= '</div>' ?>
<?= $this->Form->end() ?>
