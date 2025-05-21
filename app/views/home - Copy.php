<?php $title = "Welcome to Kinde ERP"; ?>

<div class="container">
    <h1>Welcome to Your Dashboard</h1>


    - weekly Progress (week 1 90%, week 2 80%)
    - Overall Progress ()
    status - no of activites.

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
            <div class="card-value">9</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                Completed
                <button>
                    <svg viewBox="0 0 24 24">
                        <path fill="currentColor" d="M14 12V17H10V12L4 4H20L14 12M6 18H18V20H6V18Z" />
                    </svg>
                </button>
            </div>
            <div class="card-value">1</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                Cancelled
                <button>
                    <svg viewBox="0 0 24 24">
                        <path fill="currentColor" d="M14 12V17H10V12L4 4H20L14 12M6 18H18V20H6V18Z" />
                    </svg>
                </button>
            </div>
            <div class="card-value">0</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                Postponed
                <button>
                    <svg viewBox="0 0 24 24">
                        <path fill="currentColor" d="M14 12V17H10V12L4 4H20L14 12M6 18H18V20H6V18Z" />
                    </svg>
                </button>
            </div>
            <div class="card-value">0</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                Overdue
                <button>
                    <svg viewBox="0 0 24 24">
                        <path fill="currentColor" d="M14 12V17H10V12L4 4H20L14 12M6 18H18V20H6V18Z" />
                    </svg>
                </button>
                <button>...</button>
            </div>
            <div class="card-value">7</div>
        </div>
    </div>


<br><br>



















<style>
  :root {
    --bg-page:    #f8f9fa;
    --bg-table:   #fff;
    --border:     #e0e0e0;
    --text-base:  #555;
    --hover-row:  #f5f5f5;
    --hover-add:  #e9ecef;
    --blue:       #007bff;
    --warning:    #ff8c00;
  }

  table.task-table {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    background: var(--bg-table);
    border-radius: 8px;
    overflow: hidden;
  }

  .task-table th,
  .task-table td {
    padding: 12px 15px;
    border: 1px solid var(--border);
    text-align: left;
  }

  .task-table th {
    background: #f2f2f2;
    color: var(--text-base);
    font-weight: bold;
  }

  .task-table tbody tr:hover {
    background: var(--hover-row);
  }

  /* Column widths */
  .col-checkbox { width: 40px;  text-align: center; }
  .col-task     { width: 35%;               }
  .col-owner    { width: 10%;  text-align: center; }
  .col-status   { width: 15%;               }
  .col-due      { width: 10%;               }
  .col-priority { width: 10%;  text-align: center; }

  /* Badge base */
  .badge {
    display: inline-block;
    padding: 5px 8px;
    border-radius: 5px;
    font-size: 0.9em;
  }

  /* Wide badges (for priorities) */
  .badge--wide {
    padding-left: 10px;
    padding-right: 10px;
  }

  /* Status variants */
  .status-pending { background: #f0f8ff; color: #6495ed; }
  .status-oac     { background: #e0ffe0; color: #2e8b57; }
  .status-stuck   { background: #ffe0e0; color: #dc143c; }

  /* Priority variants */
  .priority-medium { background: #6a5acd; color: #fff; }
  .priority-high   { background: #800080; color: #fff; }

  /* Owner avatar */
  .owner-icon {
    width: 24px;  height: 24px;
    border-radius: 50%;
    background: #ccc;
    color: #fff;
    font-size: 0.8em;
    font-weight: bold;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin-right: 5px;
  }

  /* Add‐task row */
  .add-task {
    color: var(--blue);
    cursor: pointer;
    font-size: 0.9em;
    text-align: left;
  }
  .add-task:hover {
    background: var(--hover-add);
  }

  /* Icon button */
  .icon-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    margin-left: 5px;
    color: #777;
  }
  .icon-btn svg {
    width: 16px;
    height: 16px;
    fill: currentColor;
  }

  /* Due‐date warning icon */
  .warning {
    color: var(--warning);
    margin-left: 5px;
  }
</style>

<table class="task-table">
  <thead>
    <tr>
      <th class="col-checkbox"><input type="checkbox" /></th>
      <th class="col-task">Task</th>
      <th class="col-owner">Owner</th>
      <th class="col-status">Status</th>
      <th class="col-due">Due Date</th>
      <th class="col-priority">Priority</th>
      <th>Notes</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="col-checkbox"><input type="checkbox" /></td>
      <td class="col-task">
        FTTB - Seme Technical and Vocational College
        <button class="icon-btn">
          <svg viewBox="0 0 24 24">
            <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
          </svg>
        </button>
      </td>
      <td class="col-owner"><span class="owner-icon">KO</span></td>
      <td class="col-status">
        <span class="badge status-pending">Pending Deploy…</span>
      </td>
      <td class="col-due">May 21 2025</td>
      <td class="col-priority">
        <span class="badge badge--wide priority-medium">Medium</span>
      </td>
      <td>Pending material issuance by client</td>
    </tr>

    <tr>
      <td class="col-checkbox"><input type="checkbox" /></td>
      <td class="col-task">
        FTTB - K-City Business Centre
        <button class="icon-btn">
          <svg viewBox="0 0 24 24">
            <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
          </svg>
        </button>
      </td>
      <td class="col-owner"><span class="owner-icon">AB</span></td>
      <td class="col-status">
        <span class="badge status-oac">OAC/FAC Received</span>
      </td>
      <td class="col-due">May 18 2025 <span class="warning">⚠️</span></td>
      <td class="col-priority">
        <span class="badge badge--wide priority-high">High</span>
      </td>
      <td>Approved for deployment</td>
    </tr>

    <tr>
      <td class="col-checkbox"><input type="checkbox" /></td>
      <td class="col-task">
        FTTB - Kisumu Central
        <button class="icon-btn">
          <svg viewBox="0 0 24 24">
            <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
          </svg>
        </button>
      </td>
      <td class="col-owner"><span class="owner-icon">MN</span></td>
      <td class="col-status">
        <span class="badge status-stuck">Stuck</span>
      </td>
      <td class="col-due">—</td>
      <td class="col-priority">—</td>
      <td>Waiting client feedback</td>
    </tr>

    <tr class="add-task">
      <td colspan="7">+ Add task</td>
    </tr>
  </tbody>
</table>
