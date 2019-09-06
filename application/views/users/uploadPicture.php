<?php

/** @var array $errors */

$upload = [
    'name' => 'filename',
    'class' => 'custom-file-input',
    'id' => 'customId',
    'required' => 'required'
];

$submit = [
    'name' => 'upload',
    'value' => 'Upload',
    'class' => 'btn btn-info'
];

?>

<hr>
<br />

<div class="wrapper">
    <h3>Select picture to upload:</h3>
    <?= form_open_multipart(base_url('handle-upload'), ['class' => 'was-validated']) ?>

    <div class="custom-file">
        <?= form_upload($upload) ?><br />
        <label for="customFile" class="custom-file-label upload-label">Choose file</label>
    </div>
    <?= form_submit($submit) ?>

    <?= form_close() ?>

    <?php
    if ($errors):
        foreach ($errors as $error): ?>

            <div class="alert-message">
                <?= $error ?>
            </div>

        <?php
        endforeach;
    endif; ?>
</div>
