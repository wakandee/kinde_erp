<?php use App\Helpers\SessionHelper; 
use App\Helpers\RBACHelper; 
$userId = SessionHelper::get('user_id'); //var_dump($tasks)?>

<style>
.activities-header { margin: 1em auto; }
.filter-form { display: flex; flex-direction: column; gap: 1em; }
.interval-slider { position: relative; width: 100%; margin-bottom: 0.5em; }
.slider-tabs { display: flex; }
.slider-tab { flex: 1; text-align: center; padding: 0.5em 0; cursor: pointer; }
.slider-tab.active { font-weight: bold; }
.slider-indicator { position: absolute; bottom: 0; height: 3px; background: #007bff; transition: left 0.3s, width 0.3s; }
.nav-controls { display: flex; align-items: center; gap: 1em; }
.picker-container input { padding: 0.3em; }
.btn-add, .btn-filter { padding: 0.4em 0.8em; background: #007bff; color: #fff; border: none; border-radius: 4px; text-decoration: none; }
.btn-add:hover, .btn-filter:hover { background: #0056b3; }
</style>

<h3>My Daily Weekly Tracker</h3>
<hr><wbr>

<?php if (RBACHelper::has_permission('Create', 'activities')): ?>
  <a href="<?= $base_url ?>activities/create">Add New Activity</a>
<?php endif; ?>

<br><br>
<form method="GET" action="">
    <label>Filter by Activity Date:</label>
    <input type="date" name="activity_date" value="<?= htmlspecialchars($activityDate) ?>">
    <button type="submit">Filter</button>
</form>

<br><br>

<!-- Activities Filter and Interval Header -->
<div class="activities-header">
  <h3>My Daily Weekly Tracker</h3>
  <hr>
  <?php if (RBACHelper::has_permission('Create', 'activities')): ?>
    <a class="btn-add" href="<?= $base_url ?>activities/create">Add New Activity</a>
  <?php endif; ?>

  <form id="filterForm" method="GET" action="" class="filter-form">
    <!-- Hidden fields to carry current interval and picker value -->
    <input type="hidden" name="interval" id="intervalInput" value="<?= htmlspecialchars($interval ?? 'daily') ?>">
    <input type="hidden" name="picker" id="pickerInput" value="<?= htmlspecialchars($pickerValue ?? '') ?>">

    <!-- Interval Tabs Slider -->
    <div class="interval-slider">
      <div class="slider-tabs">
        <div class="slider-tab" data-interval="daily">Daily</div>
        <div class="slider-tab" data-interval="weekly">Weekly</div>
        <div class="slider-tab" data-interval="monthly">Monthly</div>
      </div>
      <div class="slider-indicator"></div>
    </div>

    <!-- Prev / Picker / Next Controls -->
    <div class="nav-controls">
      <button type="button" id="prevBtn" onclick="changeDate('prev')">&larr; Prev</button>

      <div class="picker-container">
        <!-- Will be swapped based on interval -->
        <input type="date" id="datePicker" onchange="updatePicker(this.value)">
        <input type="week" id="weekPicker" onchange="updatePicker(this.value)" style="display:none;">
        <input type="month" id="monthPicker" onchange="updatePicker(this.value)" style="display:none;">
      </div>

      <button type="button" id="nextBtn" onclick="changeDate('next')">Next &rarr;</button>
    </div>

    <button type="submit" class="btn-filter">Filter</button>
  </form>
</div>


<?php if (!empty($tasks)): ?>
    <table border="2" cellpadding="6" style="width: 100%;">
        <thead>
            <tr>
                <th>Date</th>
                <th>Week</th>
                <th>Title</th>
                <th>Task</th>
                <th>Deliverable</th>
                <th>Assignee</th>
                <th>Resource</th>
                <th>Status</th>
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
                            <a href="<?= $base_url ?>activities/tasks/<?= $task->task_id ?>/history"
                               title="View edit history"
                               style="color: orange; text-decoration: none;"
                               onmouseover="showTooltip(this, '<?= htmlspecialchars($task->old_task ?? 'Original task not loaded') ?>')"
                               onmouseout="hideTooltip(this)">
                                [Edited]
                            </a>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($task->deliverable) ?></td>
                    
                    <td><?= htmlspecialchars($task->assignee_name ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($task->resource ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($task->status) ?></td>
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
                        <?php if ($task->created_by === $userId): ?>
                            <a href="<?= $base_url ?>activities/tasks/<?= $task->task_id ?>/edit" title="Edit task (creator only)">Edit</a>
                        <?php else: ?>
                            <span title="Only the creator can edit this task" style="color: #aaa; cursor: not-allowed;">Edit</span>
                        <?php endif; ?>

                        &nbsp;|&nbsp;

                        <?php if ($task->assignee_id === $userId): ?>
                            <a href="<?= $base_url ?>activities/update_status/<?= $task->task_id ?>" title="Update task status (assignee only)">Update Status</a>
                        <?php else: ?>
                            <span title="Only the assignee can update status" style="color: #aaa; cursor: not-allowed;">Update Status</span>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No activities found for the current week.</p>
<?php endif; ?>

<script>
function showTooltip(el, text) {
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = "Before: " + text;
    tooltip.style.position = 'absolute';
    tooltip.style.backgroundColor = '#fff8dc';
    tooltip.style.border = '1px solid #ccc';
    tooltip.style.padding = '4px 8px';
    tooltip.style.fontSize = '0.85em';
    tooltip.style.color = '#333';
    tooltip.style.boxShadow = '0px 0px 4px rgba(0,0,0,0.2)';
    tooltip.style.zIndex = '999';
    el._tooltip = tooltip;
    document.body.appendChild(tooltip);

    const rect = el.getBoundingClientRect();
    tooltip.style.left = `${rect.left + window.scrollX + 10}px`;
    tooltip.style.top = `${rect.top + window.scrollY + 20}px`;
}

function hideTooltip(el) {
    if (el._tooltip) {
        document.body.removeChild(el._tooltip);
        el._tooltip = null;
    }
}
</script>

<!-- JavaScript -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.slider-tab');
    const indicator = document.querySelector('.slider-indicator');
    const intervalInput = document.getElementById('intervalInput');
    const picker = {
      daily: document.getElementById('datePicker'),
      weekly: document.getElementById('weekPicker'),
      monthly: document.getElementById('monthPicker')
    };

    function selectTab(interval) {
      tabs.forEach(tab => tab.classList.toggle('active', tab.dataset.interval === interval));
      intervalInput.value = interval;
      updateIndicator();
      updatePickersVisibility(interval);
    }

    function updateIndicator() {
      const active = document.querySelector('.slider-tab.active');
      indicator.style.left = active.offsetLeft + 'px';
      indicator.style.width = active.offsetWidth + 'px';
    }

    function updatePickersVisibility(interval) {
      Object.keys(picker).forEach(key => {
        picker[key].style.display = (key === interval ? 'inline-block' : 'none');
      });
      // Set picker value from hidden field
      picker[interval].value = document.getElementById('pickerInput').value;
    }

    tabs.forEach(tab => {
      tab.addEventListener('click', () => selectTab(tab.dataset.interval));
    });

    // Initialize on load
    selectTab(intervalInput.value || 'daily');
  });

  function updatePicker(val) {
    document.getElementById('pickerInput').value = val;
  }

  function changeDate(direction) {
    const interval = document.getElementById('intervalInput').value;
    let current = document.getElementById(interval + 'Picker').value;
    let dateObj;

    switch(interval) {
      case 'daily':
        dateObj = new Date(current);
        dateObj.setDate(dateObj.getDate() + (direction === 'next' ? 1 : -1));
        document.getElementById('datePicker').value = dateObj.toISOString().slice(0,10);
        updatePicker(document.getElementById('datePicker').value);
        break;
      case 'weekly':
        // ISO week handling: adjust by 7 days
        dateObj = new Date(current + '-1'); // week to date
        dateObj.setDate(dateObj.getDate() + (direction === 'next' ? 7 : -7));
        const y = dateObj.getFullYear();
        const w = getWeekNumber(dateObj);
        document.getElementById('weekPicker').value = y + '-W' + String(w).padStart(2,'0');
        updatePicker(document.getElementById('weekPicker').value);
        break;
      case 'monthly':
        const [yM,yMo] = current.split('-');
        let year = parseInt(yM), month = parseInt(yMo);
        month += (direction === 'next' ? 1 : -1);
        if(month>12){month=1;year++;} if(month<1){month=12;year--;}
        document.getElementById('monthPicker').value = year + '-' + String(month).padStart(2,'0');
        updatePicker(document.getElementById('monthPicker').value);
        break;
    }
  }

  function getWeekNumber(d) {
    d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
    const dayNum = d.getUTCDay() || 7;
    d.setUTCDate(d.getUTCDate() + 4 - dayNum);
    const yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
    return Math.ceil((((d - yearStart) / 86400000) + 1)/7);
  }
</script>