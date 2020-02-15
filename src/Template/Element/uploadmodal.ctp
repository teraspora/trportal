<?= $this->Form->create($results, ['class' => 'form-inline', 'id' => 'upload-form', 'type' => 'post', 'enctype' => 'multipart/form-data', 'url' => ['action' => 'import']]); ?>
<h2 class="import-hint text-center mt-5">Please choose a file to import</h2>       

<?= $this->Form->file('uploaded_file', ['id' => 'csv-input']); ?> 
<?= $this->Form->button(__('Send File'), ['class' => 'btn btn-info btn-xs mx-5', 'id' => 'csv-submit']); ?>
