<div class="container d-inline-flex h-100">
  <div class="card bg-dark pt-5 justify-content-right align-items-center">
    <div class="card-body">
        <?= $this->Form->create(); ?>
        <?= $this->Form->input('email'); ?>
        <?= $this->Form->input('password', ['type' => 'password']); ?>
        <?= $this->Form->submit('Login', ['class' => 'button']); ?>    
        <?= $this->Form->end(); ?>
    </div>
  </div>
</div>