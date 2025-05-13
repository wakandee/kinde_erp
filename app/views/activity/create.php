<h2>Add New Weekly Activity</h2>

<form method="POST" action="<?= $base_url ?>activity">
    <label for="activity-date">Activity Date:</label>
    <input type="date" name="activity_date" id="activity-date" required><br><br>

    <label for="week-display">Week:</label>
    <input type="text" id="week-display" name="week" readonly><br><br>

    <label for="title">Work Title:</label>
    <input type="text" name="title" required><br><br>

    <h4>Tasks</h4>
    <table id="tasks-table" border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Task</th>
                <th>Assignee</th>
                <th>Deliverable</th>
                <th>Resource</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tasks-body">
            <tr>
                <td><input type="text" name="tasks[0][task]" required></td>
                <td>
                    <select name="tasks[0][assignee]" required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user->id ?>" <?= $user->id == $currentUserId ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user->name) ?>
                                <?= $user->id == $currentUserId ? '(Self)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="text" name="tasks[0][deliverable]" required></td>
                <td><input type="text" name="tasks[0][resource]" required></td>
                <td><button type="button" onclick="removeTaskRow(this)">🗑</button></td>
            </tr>
        </tbody>
    </table>
    <br>
    <button type="button" onclick="addTaskRow()">Add Task +</button><br><br>

    <button type="submit">Submit Activity</button>
</form>

<script>
document.getElementById('activity-date').addEventListener('change', function () {
    const date = new Date(this.value);
    if (!isNaN(date)) {
        const weekNumber = getWeekNumber(date);
        document.getElementById('week-display').value = 'Wk ' + weekNumber;
    }
});

function getWeekNumber(d) {
    d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
    const dayNum = d.getUTCDay() || 7;
    d.setUTCDate(d.getUTCDate() + 4 - dayNum);
    const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
    return Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
}

let taskIndex = 1;
function addTaskRow() {
    const tbody = document.getElementById('tasks-body');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type="text" name="tasks[${taskIndex}][task]" required></td>
        <td>
            <select name="tasks[${taskIndex}][assignee]" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user->id ?>" <?= $user->id == $currentUserId ? 'selected' : '' ?>>
                        <?= htmlspecialchars($user->name) ?> <?= $user->id == $currentUserId ? '(Self)' : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td><input type="text" name="tasks[${taskIndex}][deliverable]" required></td>
        <td><input type="text" name="tasks[${taskIndex}][resource]" required></td>
        <td><button type="button" onclick="removeTaskRow(this)">🗑</button></td>
    `;
    tbody.appendChild(row);
    taskIndex++;
}

function removeTaskRow(button) {
    const row = button.closest('tr');
    row.remove();
}
</script>
