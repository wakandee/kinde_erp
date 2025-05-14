<?php
use App\Helpers\SessionHelper;
?>

<h2>Create Weekly Activity</h2>

<form method="POST" action="<?= \$base_url ?>activities/store">
    <label>Activity Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Week:</label><br>
    <input type="text" name="week" value="<?= date('W') ?>" required><br><br>

    <label>Date:</label><br>
    <input type="date" name="activity_date" value="<?= date('Y-m-d') ?>" required><br><br>

    <h3>Tasks</h3>
    <div id="task-rows">
        <div class="task-row">
            <label>Task:</label>
            <input type="text" name="tasks[0][task]" required>

            <label>Deliverable:</label>
            <input type="text" name="tasks[0][deliverable]" required>

            <label>Assignee:</label>
            <select name="tasks[0][assignee_id]">
                <?php foreach (\$users as \$user): ?>
                    <option value="<?= \$user->id ?>" <?= \$user->id === \$currentUserId ? 'selected' : '' ?>>
                        <?= htmlspecialchars(\$user->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Resource:</label>
            <input type="text" name="tasks[0][resource]">
        </div>
    </div>

    <button type="button" onclick="addTaskRow()">+ Add Task</button><br><br>
    <button type="submit">Save Activity</button>
</form>

<script>
let taskIndex = 1;
function addTaskRow() {
    const container = document.getElementById('task-rows');
    const row = document.createElement('div');
    row.className = 'task-row';
    row.innerHTML = `
        <label>Task:</label>
        <input type="text" name="tasks[\${taskIndex}][task]" required>

        <label>Deliverable:</label>
        <input type="text" name="tasks[\${taskIndex}][deliverable]" required>

        <label>Assignee:</label>
        <select name="tasks[\${taskIndex}][assignee_id]">
            <?php foreach (\$users as \$user): ?>
                <option value="<?= \$user->id ?>" <?= \$user->id === \$currentUserId ? 'selected' : '' ?>>
                    <?= htmlspecialchars(\$user->name) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Resource:</label>
        <input type="text" name="tasks[\${taskIndex}][resource]">
    `;
    container.appendChild(row);
    taskIndex++;
}
</script>
