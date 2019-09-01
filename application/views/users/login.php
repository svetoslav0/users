<h1>Login</h1>
<hr>

<?= form_open(base_url('handle-login')) ?>

<!--Email input-->
<label for="email">Email</label>
<?= form_input([
    'name' => 'email',
    'id' => 'email',
    'type' => 'email',
    'placeholder' => 'Email'
]) ?>
<br />

<!--Password input-->
<label for="password">Password</label>
<?= form_input([
    'name' => 'password',
    'id' => 'password',
    'type' => 'password',
    'placeholder' => 'Password'
]) ?>
<br />

<!--Submit button-->
<?= form_submit([
    'name' => 'login',
    'value' => 'Login!'
]) ?>

<?= form_close() ?>

<?php if ($this->session->flashdata('error')): ?>
    <div>
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>
<div>
    If you do not have an account, you can <a href="<?= base_url('register') ?>">register</a>
</div>
