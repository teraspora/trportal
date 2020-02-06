<?= $this->Form->create(null, ['class' => 'form-inline', 'type' => 'file', 'url' => ['action' => 'import']]); ?>
<?= $this->Form->button(__('Export'), ['action' => 'export', 'class' => 'btn btn-info']) ?>
<?= '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#uploadModal">Import</button>'; ?>
<?= $this->Form->end;


