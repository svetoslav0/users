<?php
/** @var object $userdata */
?>

<h3>Welcome back, <?= $userdata->first_name ?></h3>

<?php if ($this->session->flashdata('success')): ?>
<div class="wrapper">
    <div class="alert alert-success">
        <?= $this->session->flashdata('success') ?>
    </div>
</div>
<?php endif; ?>

<hr>
<?php if ($userdata->picture_url == null): ?>
    <a href="<?= base_url('upload-picture') ?>">Upload Profile Picture</a>
<?php else: ?>
        <div class="img-container">
            <div class="top-img-half">
                <a href="<?= base_url() . 'application\public\images\\' . $userdata->picture_url ?>" class="hidden-top-img-half" target="_blank">
                    View picture
                </a>
            </div>
            <img class="profile-img" src="<?= base_url() . 'application\public\images\\' . $userdata->picture_url ?>" alt="profile_picture">
            <div class="bottom-img-half">
                <a href="<?= base_url('upload-picture') ?>" class="hidden-bottom-img-half">
                    Change picture
                </a>
            </div>
        </div>
<?php endif; ?>
<table class="wrapper">
    <tr>
        <td>
            <a class="btn btn-info link-btn" href="<?= base_url('upload-picture') ?>">Change Profile Picture</a>
        </td>
    </tr>
    <tr>
        <td>
            <a class="btn btn-info link-btn" href="<?= base_url('edit-profile') ?>">Edit My Profile</a>
        </td>
    </tr>
    <tr>
        <td>
            <a class="btn btn-info link-btn" href="<?= base_url('change-password') ?>">Change My Password</a>
        </td>
    </tr>
    <tr>
        <td>
            <a class="btn btn-info link-btn" href="<?= base_url('view-all-users') ?>">View All Users</a>
        </td>
    </tr>
</table>
