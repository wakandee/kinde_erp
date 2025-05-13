<h2>Weekly Tracker</h2>
<a href="<?= $base_url ?>tracker/create">Add Activity</a><br><br>

<?php if (!empty($activity)): ?>
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
<?php else: ?>
    <p>No activity Found.</p>
<?php endif; ?>