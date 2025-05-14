<?php use App\Helpers\SessionHelper; ?>

<h2>My Daily Weekly Tracker</h2>
<a href="<?= $base_url ?>activities/create">Add New Activity</a>

<?php if (!empty($tasks)): ?>
    <table border="1" cellpadding="6" style="width: 100%;">
        <thead>
            <tr>
                <th>Date</th>
                <th>Week</th>
                <th>Title</th>
                <th>Task</th>
                <th>Status</th>
                <th>Assignee</th>
                <th>Latest Comment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task):
            //var_dump($task); echo "<br><br>"; ?>
                <tr>
                    <td><?= date('D d-m', strtotime($task->activity_date)) ?></td>
                    <td><?= htmlspecialchars($task->week_number) ?></td>
                    <td><?= htmlspecialchars($task->activity_title) ?></td>
                    <td>
                        <strong><?= htmlspecialchars($task->task) ?></strong>
                        <?php if (!empty($task->is_edited)): ?>
                            <span style="color: orange;">[Edited]</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($task->status) ?></td>
                    <td><?= htmlspecialchars($task->assignee_name ?? 'N/A') ?></td>
                    <td>
                        <?php
                            $latest = $latestComments[$task->task_id] ?? null;
                            if ($latest):
                        ?>
                            <div><em>“<?= htmlspecialchars(mb_strimwidth($latest, 0, 50, "...")) ?>”</em></div>
                            <div><a href="<?= $base_url ?>activities/tasks/<?= $task->task_id ?>/comments">View All Comments</a></div>
                        <?php else: ?>
                            <span>No updates</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= $base_url ?>activities/tasks/<?= $task->task_id ?>/edit">Edit</a> |
                        <a href="<?= $base_url ?>activities/update_status/<?= $task->task_id ?>">Update Status</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No activities found for the current week.</p>
<?php endif; ?>
