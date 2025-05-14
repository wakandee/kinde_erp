<h3>Staff List</h3>
<hr><wbr>
<a href="<?= $base_url ?>users/create">+ Add Staff</a><wbr><br><br>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user->name); ?></td>
            <td><?= htmlspecialchars($user->email); ?></td>
            <td><?= htmlspecialchars($user->username); ?></td>
            <td><?= htmlspecialchars($user->department_name ?? 'N/A'); ?></td>
            <td><?= htmlspecialchars($user->designation_name ?? 'N/A'); ?></td>
            <td>
                <a href="<?= $base_url ?>users/edit/<?= $user->id ?>">Edit</a>
                <a href="<?= $base_url ?>users/destroy/<?= $user->id ?>" onclick="return confirm('Delete this user?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
