<?php
/** @var object $user */

$email = [
    'type' => 'email',
    'value' => $user->email ?? set_value('email'),
    'name' => 'email',
    'id' => 'email',
    'placeholder' => 'Email'
];

$firstName = [
    'value' => $user->first_name ?? set_value('first_name'),
    'name' => 'first_name',
    'id' => 'first_name',
    'placeholder' => 'First Name'
];

$lastName = [
    'value' => $user->last_name ?? set_value('last_name'),
    'name' => 'last_name',
    'id' => 'last_name',
    'placeholder' => 'Last Name'
];

$submit = [
    'value' => 'Edit',
    'name' => 'edit',
    'class' => 'btn btn-primary btn-sign'
];

?>

<div class="wrapper">
    <div class="form-content">
        <h2>Edit Your Profile</h2>
        <hr>
        <br/>


        <?= form_open(base_url('handle-edit')) ?>

        <div class="container">
            <div class="row">
                <div class="col-md label">
                    <label for="email">
                        Email:
                    </label>
                </div>
                <div class="col-md">
                    <?= form_input($email) ?>
                </div>
            </div>

            <?php if (form_error('email')): ?>
                <div class="alert-message">
                    <?= form_error('email') ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md label">
                    <label for="first_name">
                        First Name:
                    </label>
                </div>
                <div class="col-md">
                    <?= form_input($firstName) ?>
                </div>
            </div>

            <?php if (form_error('first_name')): ?>
                <div class="alert-message">
                    <?= form_error('first_name') ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md label">
                    <label for="last_name">
                        Last Name:
                    </label>
                </div>
                <div class="col-md">
                    <?= form_input($lastName) ?>
                </div>
            </div>

            <?php if (form_error('last_name')): ?>
                <div class=alert-message>
                    <?= form_error('last_name') ?>
                </div>
            <?php endif; ?>

            <?= form_submit($submit) ?>
            <?= form_close() ?>
        </div>

    </div>
</div>
