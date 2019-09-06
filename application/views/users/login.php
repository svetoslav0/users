<?php

$email = [
    'name' => 'email',
    'id' => 'email',
    'type' => 'email',
    'placeholder' => 'Email'
];

$password = [
    'name' => 'password',
    'id' => 'password',
    'type' => 'password',
    'placeholder' => 'Password'
];

$submit = [
    'name' => 'login',
    'value' => 'Login!',
    'class' => 'btn btn-primary btn-sign'
];

?>

<div class="wrapper">
    <div class="title">
        <h1>Login</h1>
    </div>
</div>
<hr>
<br />

<div class="wrapper">
    <div class="form-content">
        <?= form_open(base_url('handle-login')) ?>

        <div class="container">

            <div class="row">
                <div class="col-md label">
                    <label for="email">Email</label>
                </div>
                <div class="col-md">
                    <?= form_input($email) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md label">
                    <label for="password">Password</label>
                </div>
                <div class="col-md">
                    <?= form_input($password) ?>
                </div>
            </div>

            <?= form_submit($submit) ?>
        </div>

        <?= form_close() ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert-message">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <div>
            If you do not have an account, you can <a href="<?= base_url('register') ?>">register</a>
        </div>

    </div>
</div>
