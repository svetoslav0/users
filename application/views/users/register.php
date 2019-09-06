<?php

$email = [
    'name' => 'email',
    'id' => 'email',
    'type' => 'email',
    'placeholder' => 'Email',
    'value' => set_value('email')
];

$password = [
    'name' => 'password',
    'id' => 'password',
    'placeholder' => 'Password'
];

$confirm = [
    'name' => 'confirm',
    'id' => 'confirm',
    'placeholder' => 'Confirm Password'
];

$firstName = [
    'name' => 'first_name',
    'id' => 'first_name',
    'placeholder' => 'First Name',
    'value' => set_value('first_name')
];

$lastName = [
    'name' => 'last_name',
    'id' => 'last_name',
    'placeholder' => 'Last Name',
    'value' => set_value('last_name')
];

$submit = [
    'name' => 'register',
    'value' => 'Register!',
    'class' => 'btn btn-primary btn-sign'
];

?>

<div class="wrapper">
    <div class="title">
        <h1>Register</h1>
    </div>
</div>
<hr>
<br/>


<div class="wrapper">
    <div class="form-content">
        <?= form_open(base_url('handle-register')) ?>

        <div class="row">
            <div class="col-md label">
                <label for="email">Email: </label>
            </div>
            <div class="col-md">
                <?= form_input($email) ?>
            </div>
        </div>

        <?php if (form_error('email')): ?>
            <div class="alert-message">
                <?= form_error('email') ?>
            </div>
            <br/>
        <?php endif; ?>


        <div class="row">
            <div class="col-md label">
                <label for="password">Password: </label>
            </div>
            <div class="col-md">
                <?= form_password($password) ?>
            </div>
        </div>

        <?php if (form_error('password')): ?>
            <div class="alert-message">
                <?= form_error('password') ?>
            </div>
            <br/>
        <?php endif; ?>


        <div class="row">
            <div class="col-md label">
                <label for="confirm">Confirm Password: </label>
            </div>
            <div class="col-md">
                <?= form_password($confirm) ?>
            </div>
        </div>

        <?php if (form_error('confirm')): ?>
            <div class="alert-message">
                <?= form_error('confirm') ?>
            </div>
            <br/>
        <?php endif; ?>

        <div class="row">
            <div class="col-md label">
                <label for="first_name">First Name: </label>
            </div>
            <div class="col-md">
                <?= form_input($firstName) ?>
            </div>
        </div>

        <?php if (form_error('first_name')): ?>
            <div class="alert-message">
                <?= form_error('first_name') ?>
            </div>
            <br/>
        <?php endif; ?>

        <div class="row">
            <div class="col-md label">
                <label for="last_name">Last Name: </label>
            </div>
            <div class="col-md">
                <?= form_input($lastName) ?>
            </div>
        </div>

        <?php if (form_error('last_name')): ?>
            <div class="alert-message">
                <?= form_error('last_name') ?>
            </div>
            <br/>
        <?php endif; ?>


        <?= form_submit($submit) ?>

        <?= form_close() ?>

        <div>
            You have an account? Then you can <a href="<?= base_url('login') ?>">login</a>
        </div>
    </div>
</div>
