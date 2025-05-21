<?php use App\Helpers\SessionHelper;
      use App\Helpers\RBACHelper;
      $userId     = SessionHelper::get('user_id');
      // … your PHP filter‐reading logic … 
?>
<div class="activities_header">
  <div class="activities_title_row">
    <h3 class="activities_tracker_title">My Daily Weekly Tracker</h3>
  </div>

  <!-- Single form wraps all controls: -->
  <form id="filterForm" method="GET" action="" class="activities_controls_row">
    <!-- Persisted hidden filters -->
    <input type="hidden" name="interval" id="intervalInput" value="<?= htmlspecialchars($interval) ?>">
    <input type="hidden" name="picker"   id="pickerInput"   value="<?= htmlspecialchars($pickerValue) ?>">

    <!-- Add Activity -->
    <!-- <div class="activities_control_item">
      <?php //if (RBACHelper::has_permission('Create','activities')): ?>
        <button type="button" class="activities_btn_add" onclick="location.href='<?php //= //$base_url ?>activities/create'">
          + Add Activity
        </button>
      <?php //endif; ?>
    </div> -->
    <style>
        /* Add‐task row */
  .add-task {
    color: #4ea8de;
    cursor: pointer;
    font-size: 1em;
    text-align: left;
  }
  .add-task:hover {
    font-size: 1.1em;
    transition: 0.4s;
    /*background: #444444;*/
  }



    </style>

    <div class="add-task" onclick="location.href='<?= $base_url ?>activities/create'">
      <span>+ New Task</span>
    </div>

    <!-- Interval Tabs -->
    <div class="activities_control_item">
      <div class="activities_slider_tabs">
        <div class="activities_slider_tab" data-interval="daily">Daily</div>
        <div class="activities_slider_tab" data-interval="weekly">Weekly</div>
        <div class="activities_slider_tab" data-interval="monthly">Monthly</div>
        <div class="activities_slider_indicator"></div>
      </div>
    </div>

    <!-- Date/Week/Month Picker -->
    <div class="activities_control_item activities_nav_picker">
      <button type="button" class="activities_nav_btn" id="prevBtn">&larr;</button>
      <div class="activities_picker_container">
        <input type="date"  id="datePicker"  onchange="updatePicker(this.value)">
        <input type="week"  id="weekPicker"  onchange="updatePicker(this.value)">
        <input type="month" id="monthPicker" onchange="updatePicker(this.value)">
      </div>
      <button type="button" class="activities_nav_btn" id="nextBtn">&rarr;</button>
    </div>

    <!-- Status Filter -->
    <div class="activities_control_item">
      <label for="statusSelect">Status:</label>
      <select id="statusSelect"
              name="status"
              class="activities_status_select">
        <option value="" <?= $statusFilter === '' ? 'selected' : '' ?>>All</option>
        <?php foreach (['Not Started','In Progress','Done','Postponed','Cancelled'] as $s): ?>
          <option value="<?= $s ?>" <?= $statusFilter === $s ? 'selected' : '' ?>>
            <?= htmlspecialchars($s) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Apply -->
    <div class="activities_control_item">
      <button type="submit" class="activities_btn_apply">Apply</button>
    </div>
  </form>
</div>
<br>

<style>
  .owner-icon {
  display: inline-block;
  width: 32px;
  height: 32px;
  line-height: 32px;
  text-align: center;
  border-radius: 50%;
  /*background: #0056b3;*/
  /*color: #fff;*/
  font-weight: bold;
  font-size: 0.9em;
  cursor: default;
}
.owner-icon:hover {
  background: #004494;
}

</style>



<!-- Activities Table Below -->
<?php if (!empty($tasks)): ?>
<table border="2" cellpadding="6" style="width:100%;">
  <thead><tr>
    <th>Date</th><th>Week</th><th>Title</th><th>Task</th><th>Deliverable</th>
    <th>Assignee</th><th>Resource</th><th>Due Date</th><th>Status</th><th>Latest Comment</th><th>Actions</th>
  </tr></thead>
  <tbody>
  <?php foreach ($tasks as $task): ?>
    <tr>
      <td><?= date('D d-m', strtotime($task->activity_date)) ?></td>
      <td><?= htmlspecialchars($task->week_number) ?></td>
      <td><?= htmlspecialchars($task->activity_title) ?></td>
      <td>
        <strong><?= htmlspecialchars($task->task) ?></strong>
        <?php if (!empty($task->is_edited)): ?>
          <a href="<?= $base_url ?>activities/tasks/<?= $task->task_id ?>/history"
             onmouseover="showTooltip(this,'<?= htmlspecialchars($task->old_task ?? '') ?>')"
             onmouseout="hideTooltip(this)">[Edited]</a>
        <?php endif; ?>
      </td>
      <td><?= htmlspecialchars($task->deliverable) ?></td>
      <td>
        <?php
          $name = $task->assignee_name ?? null;
          if ($name):
              // Compute initials (first two words’ first letters)
              $parts = preg_split('/\s+/', $name);
              $initials = '';
              foreach ($parts as $part) {
                  $initials .= strtoupper($part[0]);
                  if (strlen($initials) === 2) break;
              }
              // If only one word, duplicate its first letter
              if (strlen($initials) === 1) {
                  $initials .= $initials;
              }
        ?>
          <span class="owner-icon" title="<?= htmlspecialchars($name) ?>">
            <?= htmlspecialchars($initials) ?>
          </span>
        <?php else: ?>
          N/A
        <?php endif; ?>
      </td>

      <td><?= htmlspecialchars($task->resource ?? 'N/A') ?></td>
      <td><?= htmlspecialchars(date('M-d-Y',strtotime($task->due_date)) ?? 'N/A') ?></td>
      <td><?= htmlspecialchars($task->status) ?></td>
      <td>
        <?php $latest = $latestComments[$task->task_id] ?? null; ?>
        <?php if ($latest): ?>
          <em>“<?= htmlspecialchars(mb_strimwidth($latest,0,50,'...')) ?>”</em><br>
          <small><a href="<?= $base_url ?>activities/tasks/<?= $task->task_id ?>/comments">View All Comments</a></small>
        <?php else: ?>
          <span>No updates</span>
        <?php endif; ?>
      </td>
      <td><small>
        <?php if ($task->created_by === $userId): ?>
          <a href="<?= $base_url ?>activities/tasks/<?= $task->task_id ?>/edit">Edit</a>
        <?php else: ?>
          <span class="disabled">Edit</span>
        <?php endif; ?>
        &nbsp;|&nbsp;
        <?php if ($task->created_by === $userId || $task->assignee_id === $userId): ?>
          <a href="<?= $base_url ?>activities/update_status/<?= $task->task_id ?>">Update Status</a>
        <?php else: ?>
          <span class="disabled">Update Status</span>
        <?php endif; ?>
        </small>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php else: ?>
  <p>No activities found for this interval.</p>
<?php endif; ?>




<script defer>
function updatePicker(value) { document.getElementById('pickerInput').value = value; }
function changeDate(direction) {
  const iv = document.getElementById('intervalInput').value;
  const map = { daily:'datePicker', weekly:'weekPicker', monthly:'monthPicker' };
  const el = document.getElementById(map[iv]); if (!el.value) return;
  let d;
  if (iv==='daily') {
    d=new Date(el.value);
    d.setDate(d.getDate()+(direction==='next'?1:-1));
    el.value=d.toISOString().slice(0,10);
  } else if (iv==='weekly') {
    let [y,w]=el.value.split('-W').map(Number);
    d=new Date(Date.UTC(y,0,1+(w-1)*7));
    d.setUTCDate(d.getUTCDate()+(direction==='next'?7:-7));
    const nw=getWeekNumber(d);
    el.value=`${d.getUTCFullYear()}-W${String(nw).padStart(2,'0')}`;
  } else {
    let [y,m]=el.value.split('-').map(Number);
    m+=direction==='next'?1:-1;
    if(m>12){m=1;y++;}if(m<1){m=12;y--;}
    el.value=`${y}-${String(m).padStart(2,'0')}`;
  }
  updatePicker(el.value);
}
function getWeekNumber(d) { d=new Date(Date.UTC(d.getFullYear(),d.getMonth(),d.getDate())); const day=d.getUTCDay()||7; d.setUTCDate(d.getUTCDate()+4-day); const start=new Date(Date.UTC(d.getUTCFullYear(),0,1)); return Math.ceil((((d-start)/86400000)+1)/7); }
window.addEventListener('DOMContentLoaded',()=>{
  const tabs=document.querySelectorAll('.activities_slider_tab');
  const ind =document.querySelector('.activities_slider_indicator');
  const inp =document.getElementById('intervalInput');
  const pickers = {
    daily:document.getElementById('datePicker'),
    weekly:document.getElementById('weekPicker'),
    monthly:document.getElementById('monthPicker')
  };
  function sel(iv){
    tabs.forEach(t=>t.classList.toggle('active',t.dataset.interval===iv));
    inp.value=iv;
    const a=document.querySelector('.activities_slider_tab.active');
    if(a){ind.style.left=a.offsetLeft+'px';ind.style.width=a.offsetWidth+'px';}
    const val=document.getElementById('pickerInput').value;
    Object.entries(pickers).forEach(([k,el])=>{el.style.display=k===iv?'inline-block':'none'; if(k===iv)el.value=val;});
  }
  tabs.forEach(t=>t.addEventListener('click',()=>sel(t.dataset.interval)));
  sel(inp.value);
  document.getElementById('prevBtn').addEventListener('click',()=>changeDate('prev'));
  document.getElementById('nextBtn').addEventListener('click',()=>changeDate('next'));
});
</script>

<!-- Move this CSS to your external file -->
<style>
.activities_header { padding: 0 1rem; }
.activities_title_row { margin-bottom: 0.5rem; }
.activities_controls_row { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.activities_control_item { display: flex; align-items: center; }
.activities_btn_add { padding: 0.4rem 0.8rem; background: #eee; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
.activities_slider_tabs { display: flex; position: relative; }
.activities_slider_tab { padding: 0.25rem 0.5rem; cursor: pointer; }
.activities_slider_tab.active { font-weight: bold; }
.activities_slider_indicator { position: absolute; bottom: -2px; height: 2px; background: #0056b3; transition: left .3s, width .3s; }
.activities_nav_picker .activities_nav_btn { background: none; border: 1px solid #ccc; padding: 0.25rem; border-radius: 2px; cursor: pointer; }
.activities_picker_container input { padding: 0.25rem; border: 1px solid #ccc; border-radius: 2px; margin: 0 0.25rem; }
.activities_status_select, .activities_btn_apply { padding: 0.4rem 0.8rem; border-radius: 4px; }
.activities_status_select { border: 1px solid #ccc; }
.activities_btn_apply { background: #28a745; color: #fff; border: none; cursor: pointer; }
@media (max-width: 600px) {
  .activities_controls_row { flex-direction: column; align-items: flex-start; }
}
</style>
