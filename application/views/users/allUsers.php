<?php
/**
 * @var string $links
 * @var array $users
 * @var string $orderByEmailLink
 * @var string $orderByNameLink
 * @var string $orderByLastNameLink
 */
?>


<div class="wrapper">
    <h2>View All Users</h2>
    <hr>
    <br />
</div>

<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">
                <a href="<?= $orderByEmailLink ?>">Email</a>
            </th>
            <th scope="col">
                <a href="<?= $orderByNameLink ?>">First Name</a>
            </th>
            <th scope="col">
                <a href="<?= $orderByLastNameLink ?>">Last Name</a>
            </th>
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

<div class="wrapper">
    <?= $links ?>
</div>
