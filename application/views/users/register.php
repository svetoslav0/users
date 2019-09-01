<h1>Register</h1>
<hr>
<br />

<?= form_open(base_url('handle-register')) ?>

<!-- Email input -->
<label for="email">Email: </label>
<?= form_input([
    'name' => 'email',
    'id' => 'email',
    'type' => 'email',
    'placeholder' => 'Email',
    'value' => set_value('email')
]) ?>
<br />

<?php if(form_error('email')): ?>
    <div>
        <?= form_error('email') ?>
    </div>
    <br />
<?php endif; ?>

<!-- Password input -->
<label for="password">Password: </label>
<?= form_password([
    'name' => 'password',
    'id' => 'password',
    'placeholder' => 'Password'
]) ?>
<br />

<?php if(form_error('password')): ?>
    <div>
        <?= form_error('password') ?>
    </div>
    <br />
<?php endif; ?>

<!-- Confirm Password input -->
<label for="confirm">Confirm Password: </label>
<?= form_password([
    'name' => 'confirm',
    'id' => 'confirm',
    'placeholder' => 'Confirm Password'
]) ?>
<br />

<?php if(form_error('confirm')): ?>
    <div>
        <?= form_error('confirm') ?>
    </div>
    <br />
<?php endif; ?>

<!-- First Name input -->
<label for="first_name">First Name: </label>
<?= form_input([
    'name' => 'first_name',
    'id' => 'first_name',
    'placeholder' => 'First Name',
    'value' => set_value('first_name')
]) ?>
<br />

<?php if(form_error('first_name')): ?>
    <div>
        <?= form_error('first_name') ?>
    </div>
    <br />
<?php endif; ?>

<!-- Last Name input -->
<label for="last_name">Last Name: </label>
<?= form_input([
    'name' => 'last_name',
    'id' => 'last_name',
    'placeholder' => 'Last Name',
    'value' => set_value('last_name')
]) ?>
<br />

<?php if(form_error('last_name')): ?>
    <div>
        <?= form_error('last_name') ?>
    </div>
    <br />
<?php endif; ?>

<!-- Submit button -->
<?= form_submit([
    'name' => 'register',
    'value' => 'Register!'
]) ?>

<?= form_close() ?>

<div>
    You have an account? Then you can <a href="<?= base_url('login')?>">login</a>
</div>
