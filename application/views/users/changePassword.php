<?php

$newPassword = [
    'name' => 'new_password'
];

$confirmNewPassword = [
    'name' => 'confirm_new_password'
];

$oldPassword = [
    'name' => 'old_password'
];

$submit = [
    'name' => 'change',
    'value' => 'Change Password'
];

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Change Your Password</title>
</head>
<body>

<h1>Change Password</h1>
<hr>
<br/>
<a href="<?= base_url('dashboard') ?>"><< Back To Dashboard</a><br />
<br />

<?= form_open(base_url('handle-change-password')) ?>
New Password: <?= form_password($newPassword) ?><br />
<?php if (form_error('new_password')): ?>
    <div>
        <?= form_error('new_password') ?>
    </div>
<?php endif; ?>

Confirm New Password: <?= form_password($confirmNewPassword) ?><br />
<?php if (form_error('confirm_new_password')): ?>
    <div>
        <?= form_error('confirm_new_password') ?>
    </div>
<?php endif; ?>

Old Password: <?= form_password($oldPassword) ?><br />
<?php if (form_error('old_password')): ?>
    <div>
        <?= form_error('old_password') ?>
    </div>
<?php endif; ?>

<?= form_submit($submit) ?>
<?= form_close() ?>
</body>
</html>