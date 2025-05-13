<h2>Weekly Tracker</h2>
<a href="<?= $base_url ?>tracker/create">Add Activity</a><br><br>

<?php if (!empty($activity)): ?>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Name</th>
                
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            
                <?php foreach ($activities as $activity): ?>
                    <tr>
                        
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