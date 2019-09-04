<?php

/** @var array $errors */

$upload = [
    'name' => 'filename'
];

$submit = [
    'name' => 'upload',
    'value' => 'Upload'
];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload Your Profile Picture</title>
</head>
<body>

<h1>Upload Profile Picture</h1>
<hr>
<br />
<a href="<?= base_url('dashboard') ?>"><< Back To Dashboard</a><br />
<br />

<h3>Select picture to upload:</h3>
<?= form_open_multipart(base_url('handle-upload')) ?>

<?= form_upload($upload) ?><br />
<?= form_submit($submit) ?>

<?= form_close() ?>

<?php
if ($errors):
    foreach ($errors as $error): ?>

    <div><?= $error ?></div>

<?php
    endforeach;
endif; ?>

</body>
</html>