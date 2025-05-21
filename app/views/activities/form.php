<?php
use App\Helpers\SessionHelper;
use App\Helpers\RBACHelper; 

$yesterday = date('Y-m-d', strtotime('-1 day'));
$today = date('Y-m-d');

?>

<h3>Create Daily Activities</h3>
<hr>

<form method="POST" action="<?= $base_url ?>activities/store">
    <label>Date:</label><br>
    <input type="date" id="activity_date" name="activity_date" value="<?= date('Y-m-d') ?>" min="<?= $yesterday ?>" required> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <label>Week:</label>
    <input type="text" style="width: 40px;" name="week" id="weekly_display"  readonly><br><br>


    <label>New Activity:</label><br>

    <div id="task-rows">
        <div class="task_row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label>Title:</label>
            <input type="text" name="tasks[0][title]" required>

            <label>Task:</label>
            <input type="text" name="tasks[0][task]" required>

            <label>Deliverable:</label>
            <input type="text" name="tasks[0][deliverable]" required>

            <label>Assignee:</label>
            <?php if (RBACHelper::has_permission('Assign', 'activities_assign')):?>
            <select name="tasks[0][assignee_id]">
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user->id ?>" <?= $user->id === $currentUserId ? 'selected' : '' ?>>
                        <?= htmlspecialchars($user->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php else: ?>
                <select name="tasks[0][assignee_id]" disabled>
                    <option value="<?= $currentUserId ?>" selected>
                        <?= htmlspecialchars('SELF') ?>
                    </option>
                </select>
                <!-- Add a hidden input to still submit the selected user -->
                <input type="hidden" name="tasks[0][assignee_id]" value="<?= $currentUserId ?>">
            <?php endif; ?>


            <label>Resource:</label>
            <input type="text" name="tasks[0][resource]">

            <label>Due Date:</label>
            <input type="date" id="due_date" name="tasks[0][due_date]" value="<?= date('Y-m-d') ?>" min="<?= $today ?>" required> 
            <!-- <input type="text" name="tasks[0][due_date]"> -->
        </div>
    </div>

    <button type="button" onclick="addTaskRow()">+ Add Task</button><br><br><br>
    <button type="submit">Save Activity</button>
</form>
<hr>

<br><br>
<p><a href="<?= $base_url ?>activities">← Back to Activities</a></p>


<script>
  // tell JS whether we have assign‐permission
  const canAssign = <?= RBACHelper::has_permission('Assign','activities_assign') ? 'true' : 'false' ?>;
</script>



<script>
let taskIndex = 1;

function addTaskRow() {
  const container = document.getElementById('task-rows');
  const row = document.createElement('div');
  row.className = 'task_row';

  // build the assignee field based on permission
  let assigneeHTML;
  if (canAssign) {
    assigneeHTML = `
      <label>Assignee:</label>
      <select name="tasks[${taskIndex}][assignee_id]">
        <?php foreach ($users as $user): ?>
          <option value="<?= $user->id ?>" <?= $user->id === $currentUserId ? 'selected' : '' ?>>
            <?= htmlspecialchars($user->name) ?>
          </option>
        <?php endforeach; ?>
      </select>`;
  } else {
    assigneeHTML = `
      <label>Assignee:</label>
      <select name="tasks[${taskIndex}][assignee_id]" disabled>
        <option value="<?= $currentUserId ?>" selected>SELF</option>
      </select>
      <input type="hidden" name="tasks[${taskIndex}][assignee_id]" value="<?= $currentUserId ?>">`;
  }

  row.innerHTML = `
    <button type="button" class="remove-btn" 
            title="Remove Task" onclick="confirmAndRemove(this)">−</button>

    <label>Title:</label>
    <input type="text" name="tasks[${taskIndex}][title]" required>

    <label>Task:</label>
    <input type="text" name="tasks[${taskIndex}][task]" required>

    <label>Deliverable:</label>
    <input type="text" name="tasks[${taskIndex}][deliverable]" required>

    ${assigneeHTML}

    <label>Resource:</label>
    <input type="text" name="tasks[${taskIndex}][resource]">

    <label>Due Date:</label>
    <input type="date" name="tasks[${taskIndex}][due_date]" 
           value="<?= $today ?>" min="<?= $today ?>" required>`;
  
  container.appendChild(row);
  taskIndex++;
}

function confirmAndRemove(button) {
  if (confirm('Are you sure you want to remove this task row?')) {
    button.closest('.task_row').remove();
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
