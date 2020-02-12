<section class="container login-page">
    <h2 class="login-title text-center mt-5">Test Results Portal Login</h2>       
            
    <div class="login-form">
        <?= $this->Form->create(); ?>
        <?= $this->Form->input('email'); ?>
        <hr>
        <?= $this->Form->input('password', ['type' => 'password']); ?>
        <hr>
        <?= $this->Form->submit('Login', ['class' => 'button']); ?>    
        <?= $this->Form->end(); ?>
    </div>
</section>