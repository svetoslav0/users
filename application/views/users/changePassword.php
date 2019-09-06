<?php

$newPassword = [
    'name' => 'new_password',
    'id' => 'new_password',
    'placeholder' => 'New Password'
];

$confirmNewPassword = [
    'name' => 'confirm_new_password',
    'id' => 'confirm_new_password',
    'placeholder' => 'Confirm New Password'
];

$oldPassword = [
    'name' => 'old_password',
    'id' => 'old_password',
    'placeholder' => 'Old Password'
];

$submit = [
    'name' => 'change',
    'value' => 'Change Password',
    'class' => 'btn btn-primary btn-sign'
];

?>



<div class="wrapper">
    <h1>Change Password</h1>
    <hr>
    <br/>
</div>

<div class="wrapper">
    <div class="form-content">
        <?= form_open(base_url('handle-change-password')) ?>
        <div class="container">

            <div class="row">
                <div class="col-md label">
                    <label for="new_password">
                        New Password:
                    </label>
                </div>
                <div class="col-md">
                    <?= form_password($newPassword) ?>
                </div>
            </div>

            <?php if (form_error('new_password')): ?>
                <div class="alert-message">
                    <?= form_error('new_password') ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md label">
                    <label for="confirm_password">
                        Confirm New Password:
                    </label>
                </div>
                <div class="col-md">
                    <?= form_password($confirmNewPassword) ?>
                </div>
            </div>

            <?php if (form_error('confirm_new_password')): ?>
                <div class="alert-message">
                    <?= form_error('confirm_new_password') ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md label">
                    <label for="old_password">
                        Old Password:
                    </label>
                </div>
                <div class="col-md">
                    <?= form_password($oldPassword) ?>
                </div>
            </div>

            <?php if (form_error('old_password')): ?>
                <div class="alert-message">
                    <?= form_error('old_password') ?>
                </div>
            <?php endif; ?>

            <?= form_submit($submit) ?>
        </div>
        <?= form_close() ?>
    </div>
</div>
