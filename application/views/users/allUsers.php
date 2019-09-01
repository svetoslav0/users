<?php
/**
 * @var string $links
 * @var array users
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View All Users</title>
</head>
<body>

<h1>View All Users</h1>
<hr>
<br />
<a href="<?= base_url('dashboard') ?>"><< Back To Dashboard</a><br />
<br />

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->first_name ?></td>
                <td><?= $user->last_name ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $links ?>

</body>
</html>