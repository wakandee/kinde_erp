<?php
use App\Helpers\SessionHelper;

$yesterday = date('Y-m-d', strtotime('-1 day'));

?>

<h3>Create Weekly Activity</h3>
<hr>

<form method="POST" action="<?= $base_url ?>activities/store">
    <label>Date:</label><br>
    <input type="date" id="activity_date" name="activity_date" value="<?= date('Y-m-d') ?>" min="<?= $yesterday ?>" required> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <label>Week:</label>
    <input type="text" style="width: 40px;" name="week" id="weekly_display"  disabled><br><br>


    <label>Activity Title:</label><br>
    <textarea type="text" name="title" cols="40" required></textarea> <br>

    <h3>Tasks</h3>
    <div id="task-rows">
        <div class="task_row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label>Task:</label>
            <input type="text" name="tasks[0][task]" required>

            <label>Deliverable:</label>
            <input type="text" name="tasks[0][deliverable]" required>

            <label>Assignee:</label>
            <select name="tasks[0][assignee_id]">
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user->id ?>" <?= $user->id === $currentUserId ? 'selected' : '' ?>>
                        <?= htmlspecialchars($user->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Resource:</label>
            <input type="text" name="tasks[0][resource]">
        </div>
    </div>

    <button type="button" onclick="addTaskRow()">+ Add Task</button><br><br><br>
    <button type="submit">Save Activity</button>
</form>
<hr>

<br><br>
<p><a href="<?= $base_url ?>activities">← Back to Activities</a></p>

<script>
let taskIndex = 1;
function addTaskRow() {
    const container = document.getElementById('task-rows');
    const row = document.createElement('div');
    row.className = 'task_row';

    row.innerHTML = `
        <button type="button" class="remove-btn" title="Remove Task" onclick="confirmAndRemove(this)">−</button>

        <label>Task:</label>
        <input type="text" name="tasks[\${taskIndex}][task]" required>

        <label>Deliverable:</label>
        <input type="text" name="tasks[\${taskIndex}][deliverable]" required>

        <label>Assignee:</label>
        <select name="tasks[\${taskIndex}][assignee_id]">
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->id ?>" <?= $user->id === $currentUserId ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user->name) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Resource:</label>
        <input type="text" name="tasks[\${taskIndex}][resource]">
    `;

    container.appendChild(row);
    taskIndex++;
}

function confirmAndRemove(button) {
    if (confirm('Are you sure you want to remove this task row?')) {
        const row = button.closest('.task_row');
        if (row) row.remove();
    }
}
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('activity_date');
    const weekInput = document.getElementById('weekly_display');

    if (input && weekInput) {
        const date = new Date(input.value);
        if (!isNaN(date)) {
            const weekNumber = getWeekNumber(date);
            weekInput.value = weekNumber;
        }

        input.addEventListener('change', function () {
            const date = new Date(this.value);
            if (!isNaN(date)) {
                const weekNumber = getWeekNumber(date);
                weekInput.value = weekNumber;
            }
        });
    }

    function getWeekNumber(d) {
        d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
        const dayNum = d.getUTCDay() || 7;
        d.setUTCDate(d.getUTCDate() + 4 - dayNum);
        const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
        return Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
    }
});
</script>
