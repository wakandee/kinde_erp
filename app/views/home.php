<?php use App\Helpers\SessionHelper;
      $title = "Kinde | Dashboard"; 
?>

<div class="container">
    <div class="activities_header">
          
           <form id="dashboardFilterForm" method="GET" action="" class="activities_controls_row">
          <!-- hidden, dashboard-scoped -->
          <input type="hidden" name="dashboard_interval" id="dashboardIntervalInput"
                 value="<?= htmlspecialchars($dashboard_interval) ?>">
          <input type="hidden" name="dashboard_picker"   id="dashboardPickerInput"
                 value="<?= htmlspecialchars($dashboard_picker) ?>">

         <!-- Add Activity -->
        <div class="activities_control_item">
         <h3>Dashboard | <small>Weekly Tasks</small></h3>
        </div>

          <!-- interval tabs -->
          <div class="activities_control_item">
            <div class="activities_slider_tabs">
              <div class="activities_slider_tab" data-interval="daily">Daily</div>
              <div class="activities_slider_tab" data-interval="weekly">Weekly</div>
              <div class="activities_slider_tab" data-interval="monthly">Monthly</div>
              <div class="activities_slider_indicator"></div>
            </div>
          </div>

          <!-- nav picker -->
          <div class="activities_control_item activities_nav_picker">
            <button type="button" class="activities_nav_btn" id="dashboardPrevBtn">&larr;</button>
            <div class="activities_picker_container">
              <input type="date" id="dashboardDatePicker" value="<?= htmlspecialchars(SessionHelper::get('dashboard_picker_daily') ?? date('Y-m-d')) ?>" onchange="dashboardUpdatePicker(this.value)">
              
              <input type="week" id="dashboardWeekPicker" value="<?= htmlspecialchars(SessionHelper::get('dashboard_picker_weekly') ?? (date('o') . '-W' . date('W'))) ?>" onchange="dashboardUpdatePicker(this.value)">
              
              <input type="month" id="dashboardMonthPicker" value="<?= htmlspecialchars(SessionHelper::get('dashboard_picker_monthly') ?? date('Y-m')) ?>" onchange="dashboardUpdatePicker(this.value)">
            </div>
            <button type="button" class="activities_nav_btn" id="dashboardNextBtn">&rarr;</button>
          </div>

          <!-- <div class="activities_control_item activities_nav_picker">
            <button type="button" class="activities_nav_btn" id="dashboardPrevBtn">&larr;</button>
            <div class="activities_picker_container">
              <input type="date"  id="dashboardDatePicker"  onchange="dashboardUpdatePicker(this.value)">
              <input type="week"  id="dashboardWeekPicker"  onchange="dashboardUpdatePicker(this.value)">
              <input type="month" id="dashboardMonthPicker" onchange="dashboardUpdatePicker(this.value)">
            </div>
            <button type="button" class="activities_nav_btn" id="dashboardNextBtn">&rarr;</button>
          </div> -->

          <!-- apply -->
          <div class="activities_control_item">
            <button type="submit" class="activities_btn_apply">Apply</button>
          </div>
        </form>
    </div>








<!--     - weekly Progress (week 1 90%, week 2 80%)
    - Overall Progress ()
    status - no of activites. -->

</div>

    <style>
        
        .dashboard-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.dashboard-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 15px;
    text-align: center;
}

.dashboard-card .graph{
    min-width: 600px;
    max-height: 200px;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    color: #555;
    font-size: 0.9em;
    border-bottom: 1px solid #eee; /* Added line below header */
    padding-bottom: 10px; /* Add some space below the border */
}

.card-header button {
    background: none;
    border: none;
    cursor: pointer;
    color: #007bff;
    font-size: 0.9em;
    display: flex;
    align-items: center;
}

.card-header svg {
    margin-left: 5px;
    fill: currentColor;
    width: 14px;
    height: 14px;
}

.card-value {
    font-size: 2.5em;
    color: #333;
    margin-bottom: 5px;
}

.card-icon {
    color: #777;
    font-size: 1.2em;
}

.filter-icon {
    width: 16px;
    height: 16px;
    fill: #007bff;
    margin-left: 5px;
}
    </style>

    <div class="dashboard-container">
        <div class="dashboard-card">
            <div class="card-header">
                All Tasks
                <button>
                    <svg viewBox="0 0 24 24">
                        <path fill="currentColor" d="M14 12V17H10V12L4 4H20L14 12M6 18H18V20H6V18Z" />
                    </svg>
                </button>
            </div>
            <div class="card-value">
                <p><?= $totalTasks ?></p>
            </div>
        </div>

        <?php foreach ($statusCounts as $status => $count): ?>

        <div class="dashboard-card">
            <div class="card-header">
                <?= htmlspecialchars($status) ?>
                <button>
                    <svg viewBox="0 0 24 24">
                        <path fill="currentColor" d="M14 12V17H10V12L4 4H20L14 12M6 18H18V20H6V18Z" />
                    </svg>
                </button>
            </div>
            <div class="card-value"><p><?= $count ?></p></div>
        </div>

        <?php endforeach; ?>

        

       <div class="dashboard-card">
    <div class="card-header">
        Overdue
        <button>
            <svg viewBox="0 0 24 24">
                <path fill="currentColor" d="M14 12V17H10V12L4 4H20L14 12M6 18H18V20H6V18Z" />
            </svg>
        </button>
    </div>
    <div class="card-value"><?= $overdueTasks ?></div>
</div>


<div class="dashboard-card">
    <div class="card-header">
        Weekly Completion Rate
        <button>
            <svg viewBox="0 0 24 24">
                <path fill="currentColor" d="M14 12V17H10V12L4 4H20L14 12M6 18H18V20H6V18Z" />
            </svg>
        </button>
    </div>
    <div class="card-value"><?= $completionRate ?>%</div>
</div>

    </div>


<br>

<!-- === Charts Row === -->
<div class="dashboard-container" style="margin-top:2rem;">
  <!-- 1) Weekly Status Stacked Bar -->
  <div class="dashboard-card graph">
    <div class="card-header">Weekly Task Progress</div>
    <canvas id="weeklyStatusChart"></canvas>
  </div>

  <!-- 2) Completed vs Pending Pie -->
  <div class="dashboard-card graph">
    <div class="card-header ">Completed vs Pending</div>
    <canvas id="taskRatioChart"></canvas>
  </div>

  <!-- 3) Overdue Line Chart -->
  <div class="dashboard-card graph">
    <div class="card-header">Overdue (Last 7 Days)</div>
    <canvas id="overdueChart"></canvas>
  </div>
</div>


<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
  // PHP → JS
  // inject PHP data
  const weeklyLabels    = <?= json_encode($weeklyLabels) ?>;
  const weeklyStatusData = <?= json_encode($weeklyStatusData) ?>;
  const completedTasks      = <?= $completedTasks ?>;
  const pendingTasks   = <?= $pendingTasks ?>;
  const overdueCounts   = <?= json_encode($overdueCounts) ?>;
  const overdueLabels = <?= json_encode($overdueLabels) ?>;

  // Muted & Professional Color Scheme
  function getStatusColor(status) {
    return {
      'Not Started': 'rgba(108,117,125,0.6)',   // Muted gray
      'In Progress': 'rgba(52,152,219,0.6)',    // Soft blue
      'Done':        'rgba(40,180,99,0.6)',     // Muted green
      'Postponed':   'rgba(243,156,18,0.6)',    // Soft amber
      'Cancelled':   'rgba(231,76,60,0.6)'      // Soft red
    }[status] ?? 'rgba(120,120,120,0.6)';
  }

  // 1) Stacked Bar Chart – Weekly Task Status
  new Chart(document.getElementById('weeklyStatusChart'), {
    type: 'bar',
    data: {
      labels: weeklyLabels,
      datasets: Object.entries(weeklyStatusData).map(([status, data]) => ({
        label: status,
        data,
        backgroundColor: getStatusColor(status),
        borderColor: getStatusColor(status),
        borderWidth: 1
      }))
    },
    options: {
      responsive: true,
      scales: {
        x: { stacked: true },
        y: { stacked: true, beginAtZero: true }
      },
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });

  // 2) Doughnut Chart – Completion Ratio
  new Chart(document.getElementById('taskRatioChart'), {
    type: 'doughnut',
    data: {
      labels: ['Done', 'Pending'],
      datasets: [{
        data: [completedTasks, pendingTasks],
        backgroundColor: ['rgba(40,180,99,0.6)', 'rgba(149,165,166,0.6)'], // Green and soft gray
        borderColor: ['rgba(40,180,99,1)', 'rgba(149,165,166,1)'],
        borderWidth: 1
      }]
    },
    options: {
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });

  // 3) Line Chart – Overdue Trend
  new Chart(document.getElementById('overdueChart'), {
    type: 'line',
    data: {
      labels: overdueLabels,
      datasets: [{
        label: 'Overdue',
        data: overdueCounts,
        borderColor: 'rgba(52,73,94,0.9)',         // Slate blue-gray
        backgroundColor: 'rgba(52,73,94,0.2)',     // Translucent fill
        tension: 0.25,
        pointRadius: 4,
        pointBackgroundColor: 'rgba(52,73,94,1)',
        fill: true
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      },
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });
</script>


<script defer>
  function dashboardUpdatePicker(val) {
    document.getElementById('dashboardPickerInput').value = val;
  }

  function dashboardChangeDate(dir) {
    const iv = document.getElementById('dashboardIntervalInput').value;
    const map = {
      daily:   'dashboardDatePicker',
      weekly:  'dashboardWeekPicker',
      monthly: 'dashboardMonthPicker'
    };
    const el = document.getElementById(map[iv]);
    if (!el.value) return;

    let d = new Date(el.value);
    if (iv === 'daily') {
      d.setDate(d.getDate() + (dir === 'next' ? 1 : -1));
      el.value = d.toISOString().slice(0,10);

    } else if (iv === 'weekly') {
      const [y,w] = el.value.split('-W').map(Number);
      d = new Date(Date.UTC(y,0,1 + (w-1)*7));
      d.setUTCDate(d.getUTCDate() + (dir === 'next' ? 7 : -7));
      const nw = getWeekNumber(d);
      el.value = `${d.getUTCFullYear()}-W${String(nw).padStart(2,'0')}`;

    } else {
      let [Y,M] = el.value.split('-').map(Number);
      M += (dir === 'next' ? 1 : -1);
      if (M>12){ M=1; Y++; } else if (M<1){ M=12; Y--; }
      el.value = `${Y}-${String(M).padStart(2,'0')}`;
    }

    dashboardUpdatePicker(el.value);
  }

  function getWeekNumber(d) {
    d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
    const day = d.getUTCDay() || 7;
    d.setUTCDate(d.getUTCDate() + 4 - day);
    const start = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
    return Math.ceil((((d - start) / 86400000) + 1) / 7);
  }

  window.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.activities_slider_tab');
    const ind  = document.querySelector('.activities_slider_indicator');
    const inp  = document.getElementById('dashboardIntervalInput');
    const pickers = {
      daily:   document.getElementById('dashboardDatePicker'),
      weekly:  document.getElementById('dashboardWeekPicker'),
      monthly: document.getElementById('dashboardMonthPicker')
    };

    function selectTab(iv) {
      tabs.forEach(t => t.classList.toggle('active', t.dataset.interval === iv));
      inp.value = iv;
      const a = document.querySelector('.activities_slider_tab.active');
      if (a) {
        ind.style.left  = a.offsetLeft + 'px';
        ind.style.width = a.offsetWidth + 'px';
      }
      const val = document.getElementById('dashboardPickerInput').value;
      Object.entries(pickers).forEach(([k, el]) => {
        el.style.display = k === iv ? 'inline-block' : 'none';
        if (k===iv) el.value = val;
      });
    }

    tabs.forEach(t => t.addEventListener('click', () => selectTab(t.dataset.interval)));
    selectTab(inp.value);
    document.getElementById('dashboardPrevBtn').addEventListener('click', () => dashboardChangeDate('prev'));
    document.getElementById('dashboardNextBtn').addEventListener('click', () => dashboardChangeDate('next'));
  });
</script>


<style>
.activities_header { padding: 0 1rem;}
.activities_title_row { margin-bottom: 0.5rem;}
.activities_controls_row { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.activities_control_item { display: flex; align-items: center; }
.activities_btn_add { padding: 0.4rem 0.8rem; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
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

