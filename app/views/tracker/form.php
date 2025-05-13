<h2><?= isset($activity) ? 'Edit Activity' : 'Add New Activity'; ?>
<?php
$yesterday = date('Y-m-d', strtotime('-1 day'));
?>
    
</h2>

<form method="POST" action="<?= isset($activity) ? $base_url . 'tracker/' . $activity->id : $base_url . 'tracker' ?>">
    <label>Date:</label>
    <input type="date" id="activity-date" name="activity_date" required min="<?php echo $yesterday ?>">

    <label>Week:</label><input style="width: 60px;" type="text" id="week-display" name="week" disabled><br><br>

    <!-- allow minus one day  -->
    <label>Activity Title:</label>
    <input type="text" name="title" required><br><br>

    <table>
        <thead>
            <th>Task</th>
            <th>Asiignee</th>
            <th>Deliverable</th>
            <th>Resource</th>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" name="title" required></td>
                <td>
                    <select name="assignee" required>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user->id ?>" <?= ($user->id == $currentUserId) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user->name) ?>  <?= ($user->id == $currentUserId) ? '-- Self' : '' ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="text" name="deliverable" required></td>
                <td><input type="text" name="resource" required></td>
            </tr>
           
            <tr>
                <td colspan="3">Add Task +</td>
            </tr>
            
        </tbody>

    </table>
    <br><br>
    <button type="submit"> Submit</button>
</form>

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