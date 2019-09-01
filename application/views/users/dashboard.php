<?php
/** @var object $userdata */
?>

<h1>Dashboard</h1>
<h3>Welcome back, <?= $userdata->first_name ?></h3>

<?php if ($this->session->flashdata('success')): ?>
    <div>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<hr>
<?php if ($userdata->picture_url == null): ?>
    <a href="<?= base_url('upload-picture') ?>">Upload Profile Picture</a>
<?php else: ?>

<?php endif; ?>
<br /><br />

<a href="<?= base_url('edit-profile') ?>">Edit My Profile</a> |
<a href="<?= base_url('change-password') ?>">Change My Password</a><br /><br />
<a href="<?= base_url('view-all-users') ?>">View All Users</a><br /><br />
<a href="<?= base_url('logout') ?>">Logout</a>
