<?php
use App\Helpers\SessionHelper;
?>

<h2>Create Weekly Activity</h2>

<form method="POST" action="<?= $base_url ?>activities/store">
    <label>Date:</label><br>
    <input type="date" name="activity_date" value="<?= date('Y-m-d') ?>" required> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <label>Week:</label>
    <input type="text" style="width: 40px;" name="week" id="week-display"  value="<?= date('W') ?>" ><br><br>


    <label>Activity Title:</label><br>
    <input type="text" name="title" required><br><br>  

    <h3>Tasks</h3>
    <div id="task-rows">
        <div class="task-row">
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
</script>
<script>
document.getElementById('activity-date').addEventListener('change', function () {
    const date = new Date(this.value);
    if (!isNaN(date)) {
        const weekNumber = getWeekNumber(date);
        document.getElementById('week-display').value = ' Wk ' + weekNumber;
    }
});

// ISO Week Number Calculation (Monday is first day of week)
function getWeekNumber(d) {
    d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
    const dayNum = d.getUTCDay() || 7;
    d.setUTCDate(d.getUTCDate() + 4 - dayNum);
    const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
    return Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
}
</script>
