<!-- app/views/tracker/index.php -->

<h2>Weekly Tracker</h2>
<a href="<?= $base_url ?>tracker/create">Add Activity</a><br><br>

<?php if (!empty($activities)): ?>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Activity Title</th>
                <th>Task</th>
                <th>Assignee</th>
                <th>Deliverable</th>
                <th>Resource</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($activities as $activity): ?>
                <?php foreach ($activity->tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($activity->title) ?></td>
                        <td><?= htmlspecialchars($task->title) ?></td>
                        <td><?= htmlspecialchars($task->assignee_name) ?></td>
                        <td><?= htmlspecialchars($task->deliverable) ?></td>
                        <td><?= htmlspecialchars($task->resource) ?></td>
                        <td><?= htmlspecialchars($task->status) ?></td>
                        <td>
                            <a href="<?= $base_url ?>tracker/edit/<?= $task->id ?>">Edit</a> |
                            <a href="<?= $base_url ?>tracker/update_status/<?= $task->id ?>">Update Status</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No activities found.</p>
<?php endif; ?>
