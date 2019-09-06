<?php
/**
 * @var string $title
 * @var string $activeNavLink
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= base_url('application/public/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('application/public/css/style.css') ?>">
    <title><?= $title ?></title>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?= ($activeNavLink == 'dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($activeNavLink == 'editProfile') ? 'active' : '' ?>" href="<?= base_url('edit-profile') ?>">Edit Your Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($activeNavLink == 'allUsers') ? 'active' : '' ?>" href="<?= base_url('view-all-users') ?>">View All Users</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto order-0">
        <div class="collapse" id="dual-collapse2">
            <div class="bg-dark p-4">
                <h5 class="text-white h4">Collapsed content</h5>
                <span class="text-muted">Toggleable via the navbar brand.</span>
            </div>
        </div>

        <div class="navbar-brand mx-auto"><?= $title ?></div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="btn btn-secondary" href="<?= base_url('logout') ?>">Logout</a>
            </li>
        </ul>
    </div>
</nav>
