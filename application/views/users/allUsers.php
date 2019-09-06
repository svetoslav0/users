<?php
/**
 * @var string $links
 * @var array $users
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
            <th scope="col">Email</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
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
