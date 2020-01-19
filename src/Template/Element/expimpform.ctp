<?= $this->Form->create(null, ['class' => 'form-inline', 'type' => 'file', 'url' => ['action' => 'import']]); ?>
<?= '<button>' . $this->Html->link('Export', ['action' => 'export']) . '</button>'; ?>
<?= '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#uploadModal">Import</button>'; ?>
<?= $this->Form->end;