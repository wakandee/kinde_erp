
<?php use App\Helpers\SessionHelper; ?>

<h2>Edit Task</h2>

<?php if (!empty($task->is_edited) || $task->status !== 'Not Started'): ?>
    <p style="color:red;"><strong>This task can no longer be edited. It has already been edited or its status has changed.</strong></p>
    <a href="<?= $base_url ?>activities">Back to Activities</a>
<?php else: ?>
    <form method="POST" action="<?= $base_url ?>activities/tasks/<?= $task->task_id ?>/update">
        <label>Task:</label><br>
        <input type="text" name="task" value="<?= htmlspecialchars($task->task) ?>" required><br><br>

        <label>Deliverable:</label><br>
        <input type="text" name="deliverable" value="<?= htmlspecialchars($task->deliverable) ?>" required><br><br>

        <label>Resource:</label><br>
        <input type="text" name="resource" value="<?= htmlspecialchars($task->resource) ?>"><br><br>

        <button type="submit">Save Changes</button>
    </form>
<?php endif; ?>
