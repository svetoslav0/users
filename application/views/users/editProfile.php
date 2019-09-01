<?php
/** @var object $user */

$email = [
    'type' => 'email',
    'value' => $user->email ?? set_value('email'),
    'name' => 'email'
];

$firstName = [
    'value' => $user->first_name ?? set_value('first_name'),
    'name' => 'first_name',
];

$lastName = [
    'value' => $user->last_name ?? set_value('last_name'),
    'name' => 'last_name'
];

$submit = [
    'value' => 'Edit',
    'name' => 'edit'
]

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Edit Your Profile</h1>
    <hr>
    <br />
    <a href="<?= base_url('dashboard') ?>"><< Back to dashboard</a><br />
    <br />

    <?= form_open(base_url('handle-edit')) ?>
    Email: <?= form_input($email) ?><br />

    <?php if (form_error('email')): ?>
        <div>
            <?= form_error('email') ?>
        </div>
    <?php endif; ?>

    First Name: <?= form_input($firstName) ?><br >

    <?php if (form_error('first_name')): ?>
        <div>
            <?= form_error('first_name') ?>
        </div>
    <?php endif; ?>

    Last Name: <?= form_input($lastName) ?><br />

    <?php if (form_error('last_name')): ?>
        <div>
            <?= form_error('last_name') ?>
        </div>
    <?php endif; ?>

    <?= form_submit($submit) ?>
    <?= form_close() ?>
</body>
</html>