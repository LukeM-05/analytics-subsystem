<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
    require "../navbar/navbar.php";
?>

<head>
  <title>Dashboard</title>

  <script src="https://cdn.jsdelivr.net/npm/d3@7"></script>
  <link href="empStyle.css" rel=stylesheet>
</head>

<body class="dark-mode">

<script>

  async function getEmployeeName(tempEmployeeId) {
    const response = await fetch(`<?= BASE_URL ?>api/get_employee_by_id.php?employee_id=${tempEmployeeId}`);
    const data = await response.json();

    if (!data.success) {
      throw new Error(data.error);
    }

    return `${data.data.first_name} ${data.data.last_name}`;
  }

</script>

  <!-- welcome then name -->
  <div class="container-fluid" style="width: 97%; background-color: transparent; padding-top: 20px; padding-bottom: 20px;">
    <h1>
      <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
      Viewing <span id="employee-name">...</span>
    </h1>
  </div>
  <script>
    const params = new URLSearchParams(window.location.search);
    const tempEmployeeId = params.get("employee_id");

    getEmployeeName(tempEmployeeId)
      .then(name => document.getElementById("employee-name").textContent = name)
      .catch(err => {
        console.error(err);
        document.getElementById("employee-name").textContent = "Unknown";
      });
  </script>

<!-- overall container - 3 column top row -->
<div class="container-fluid bg-transparent"
     style="width: 97%; height: 600px; display: grid; grid-template-columns: 2fr 1.5fr 1fr; gap: 10px;">

  <!-- COLUMN 1: Task cards -->
<div class="container rounded-4 d-flex flex-column py-3 px-4"
     style="height: 100%; min-height: 0; overflow: hidden;">

  <div class="d-flex justify-content-between align-items-start">
    <h1 class="m-0">Tasks</h1>
    <div class="d-flex gap-2">

      <!-- search field -->
      <div style="position: relative;">
        <input id="task-search" type="text" placeholder="Search tasks..." oninput="filterTasks(this.value)" style="border: 1px solid #3a3f4b; border-radius: 20px; font-family: 'Lexend Deca', sans-serif; font-size: 0.82rem; padding: 6px 14px 6px 32px; outline: none; width: 200px; transition: border-color 0.15s;" onfocus="this.style.borderColor='#eea934'" onblur="this.style.borderColor='#3a3f4b'"/>
      </div>

      <!-- filter creation and displaying -->
      <div style="position: relative;">
        <button id="filter-btn" onclick="toggleFilterMenu()" style="border: 1px solid #3a3f4b; border-radius: 20px; font-family: 'Lexend Deca', sans-serif; font-size: 0.82rem; padding: 6px 14px; cursor: pointer; transition: border-color 0.15s; white-space: nowrap;">Sort ↕</button>

        <div id="filter-menu" style="display: none; position: absolute; top: calc(100% + 6px); right: 0; border: 1px solid #3a3f4b; border-radius: 10px; overflow: hidden; z-index: 100; min-width: 200px;">
          <div style="padding: 6px 0;">
            <div style="padding: 6px 10px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">Due Date</div>
            <button id="filter-menu" class="filter-option" onclick="applySort('due_asc')">↑ Earliest first</button>
            <button id="filter-menu" class="filter-option" onclick="applySort('due_desc')">↓ Latest first</button>
            <div style="height:1px; background:#2a2f3b; margin: 4px 0;"></div>
            <div style="padding: 6px 10px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">Progress</div>
            <button id="filter-menu" class="filter-option" onclick="applySort('progress_asc')">↑ Least complete first</button>
            <button id="filter-menu" class="filter-option" onclick="applySort('progress_desc')">↓ Most complete first</button>
          </div>
        </div>
      </div>

    </div>
  </div>

    <!-- task cards render target -->
    <div class="mt-1" id="tasks-container" style="overflow-y: auto; display: flex; flex-direction: column;"></div>
  </div>

<!-- COLUMN 2: Donut chart -->
<div class="container rounded-4 py-3 px-4 d-flex flex-column">
  <h1 class="m-0 mb-3">Task Status</h1>

  <div class="inner-container" style="flex: 1; border-radius: 24px; padding: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px;">

    <!-- chart -->
    <div style="width: 260px; height: 260px;">
      <canvas id="task-status-chart"></canvas>
    </div>

    <!-- legend below chart -->
    <div id="task-status-legend" style="width: 100%; display: flex; flex-direction: column; align-items: center; padding: 0 8px; gap: 4px;">
    </div>

<style>
  #task-status-legend li {
    list-style: none;
    position: relative;
    padding-left: 1.2em; /* space for the bullet */
  }

  #task-status-legend li::before {
    content: "•";
    position: absolute;
    left: 0;
    font-size: 4em;
    line-height: 0; /* prevents the larger character from pushing lines apart */
    top: 0.9rem;    /* vertically re-centres it */
  }

  #task-status-legend li:nth-child(1)::before { color: #28a745; }
  #task-status-legend li:nth-child(2)::before { color: #4f8ef7; }
  #task-status-legend li:nth-child(3)::before { color: #ffc107; }
  #task-status-legend li:nth-child(4)::before { color: #ff3131; }
</style>
  </div>
</div>

<!-- COLUMN 3: Modal buttons -->
  <div class="container rounded-5 py-3 px-4 d-flex flex-column gap-4" style="background: transparent; height: 100%;">
    <button type="button" class="btn modal-trigger-btn flex-fill w-100" onclick="openOverdueModal()" style="flex: 1; border: none; border-radius: 14px; font-size: 2rem; font-weight: 500; text-align: center;">Overdue Tasks</button>
    <button type="button" class="btn modal-trigger-btn flex-fill w-100" onclick="openDeadlineModal()" style="flex: 1; border: none; border-radius: 14px; font-size: 2rem; font-weight: 500; text-align: center;">Deadline Risks</button>
    <button type="button" class="btn modal-trigger-btn flex-fill w-100" onclick="openUtilisationModal()" style="flex: 1; border: none; border-radius: 14px; font-size: 2rem; font-weight: 500; text-align: center;">Utilisation</button>
  </div>

</div>

<!-- spacing! -->
</br>

<!-- bottom carousel container for graphs-->
<div class="container-fluid mt-2 mb-4 rounded-4 py-3 px-4" style="min-height: 400px; width: 95.5%;">

<div class="d-flex gap-2 justify-content-center align-items-center">
  <button class="pill-btn active" onclick="changeScreen(0)">Effort Estimation</button>
  <button class="pill-btn" onclick="changeScreen(1)">% Progress</button>
  <button class="pill-btn" onclick="changeScreen(2)">Task Dependencies</button>

  <div class="graph-info-wrapper">
    <span class="graph-info-icon" tabindex="0" aria-label="About this chart">&#9432;</span>
    <div class="graph-info-popup" id="graph-info-popup">
      <strong class="popup-title">Effort Estimation</strong>
      <p class="popup-body">Tracks cumulative effort points assigned to your tasks over time. Each point on the line represents a date where one or more tasks were created, showing how your total workload has grown.</p>
    </div>
  </div>
</div>

<!-- carousel screen one: Effort Estimation -->
<div class="carousel-screen active py-2">
  <div class="carousel-panel" style="border-radius: 24px; padding: 24px 28px;">
    <div style="position: relative; height: 580px;">
      <canvas id="effort-estimation-chart"></canvas>
    </div>
  </div>
</div>

<!-- carousel screen two: % Progress -->
<div class="carousel-screen py-2">
  <div class="carousel-panel" style="border-radius: 24px; padding: 24px;">
    <div style="position: relative; height: 580px;">
      <canvas id="project-progress-chart"></canvas>
    </div>
  </div>
</div>

<!-- carousel screen three: Task Dependencies -->
<div class="carousel-screen py-2">
  <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
    <div id="dependency-graph" class="carousel-panel" style="width: 100%; height: 600px; border-radius: 20px; overflow: hidden;"></div>
  </div>
</div>



<!-- Overdue Tasks Modal -->
<div id="overdue-modal-backdrop" onclick="closeOverdueModal()" class="modal-backdrop">
  <div onclick="event.stopPropagation()" class="modal-box" style="width: 1200px; max-height: 140vh;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <div>
        <h4 class="modal-title" style="margin: 0; font-weight: 700; font-size: 2rem;">Overdue Tasks</h4>
        <p id="overdue-subtitle" class="modal-subtitle" style="margin: 4px 0 0; font-size: 1.6rem;"></p>
      </div>
      <button onclick="closeOverdueModal()" class="modal-close-btn" style="width: 72px; height: 72px; font-size: 2.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; line-height: 1;">✕</button>
    </div>
    <div id="overdue-task-list" style="overflow-y: auto; display: flex; flex-direction: column; gap: 20px; padding-right: 8px;"></div>
  </div>
</div>

<!-- Utilisation Modal -->
<div id="utilisation-modal-backdrop" onclick="closeUtilisationModal()" class="modal-backdrop">
  <div onclick="event.stopPropagation()" class="modal-box" style="width: 1200px; max-height: 140vh;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">

      <div style="display: flex; align-items: center; gap: 10px;">
        <h4 class="modal-title" style="margin: 0; font-weight: 700; font-size: 2rem;">Utilisation</h4>
        <div class="graph-info-wrapper">
          <span class="graph-info-icon" tabindex="0" aria-label="About this chart">&#9432;</span>
          <div class="graph-info-popup">
            <strong>Utilisation</strong>
            <p>Shows how much of an employee's available capacity is currently being used across active tasks and projects. Higher utilisation indicates a heavier workload.</p>
          </div>
        </div>
      </div>

      <button onclick="closeUtilisationModal()" class="modal-close-btn" style="width: 72px; height: 72px; font-size: 2.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; line-height: 1;">✕</button>
    </div>
    <div class="chart-panel" style="position: relative; height: 420px; border-radius: 16px; padding: 16px;">
      <canvas id="utilisation-chart"></canvas>
    </div>
    <div style="display: flex; gap: 20px; justify-content: center;">
      <div style="display: flex; align-items: center; gap: 6px;">
        <div style="width: 12px; height: 12px; border-radius: 3px; background: #4f8ef7;"></div>
        <span class="modal-subtitle" style="font-size: 1.6rem;">Under utilised (&lt;80%)</span>
      </div>
      <div style="display: flex; align-items: center; gap: 6px;">
        <div style="width: 12px; height: 12px; border-radius: 3px; background: #28a745;"></div>
        <span class="modal-subtitle" style="font-size: 1.6rem;">Optimal (80–100%)</span>
      </div>
      <div style="display: flex; align-items: center; gap: 6px;">
        <div style="width: 12px; height: 12px; border-radius: 3px; background: #ff3131;"></div>
        <span class="modal-subtitle" style="font-size: 1.6rem;">Over utilised (&gt;100%)</span>
      </div>
    </div>
  </div>
</div>

<!-- Deadline Risk Modal -->
<div id="deadline-modal-backdrop" onclick="closeDeadlineModal()" class="modal-backdrop">
  <div onclick="event.stopPropagation()" class="modal-box" style="width: 1200px; max-height: 140vh;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
      <div>
        <h4 class="modal-title" style="margin: 0; font-weight: 700; font-size: 2rem;">Deadline Risk</h4>
        <p id="deadline-subtitle" class="modal-subtitle" style="margin: 4px 0 0; font-size: 1.6rem;"></p>
      </div>
      <button onclick="closeDeadlineModal()" class="modal-close-btn" style="width: 72px; height: 72px; font-size: 2.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">✕</button>
    </div>
    <div style="display: flex; gap: 8px;">
      <button class="deadline-pill active" onclick="switchDeadlineScreen('daily')">Daily</button>
      <button class="deadline-pill" onclick="switchDeadlineScreen('weekly')">Weekly</button>
      <button class="deadline-pill" onclick="switchDeadlineScreen('monthly')">Monthly</button>
       <div class="graph-info-wrapper">
        <span class="graph-info-icon" tabindex="0" aria-label="About this chart">&#9432;</span>
        <div class="graph-info-popup">
          <strong>Deadline Risk</strong>
          <p>Shows tasks with upcoming due dates grouped by time period. Helps identify which days or weeks are most at risk of deadline pressure across your projects.</p>
        </div>
      </div>
    </div>

    
    <div class="chart-panel" style="position: relative; height: 420px; border-radius: 16px; padding: 16px;">
      <canvas id="deadline-chart"></canvas>
    </div>
  </div>
</div>

<!-- Task Detail Modal -->
<div id="task-detail-backdrop" onclick="closeTaskDetailModal()" class="modal-backdrop">
  <div onclick="event.stopPropagation()" class="modal-box" style="width: 1040px; max-height: 140vh; overflow-y: auto; gap: 28px;">
    <div class="modal-header">
      <div style="flex: 1; padding-right: 16px;">
        <h4 id="td-title" class="modal-title" style="margin-bottom: 4px; font-size: 2rem;"></h4>
        <p id="td-project" class="modal-subtitle" style="margin: 0; font-size: 1.6rem;"></p>
      </div>
      <button onclick="closeTaskDetailModal()" class="modal-close-btn" style="width: 72px; height: 72px; font-size: 2.2rem; line-height: 1;">✕</button>
    </div>
    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
      <div id="td-status-badge"   class="badge-pill"></div>
      <div id="td-priority-badge" class="badge-pill"></div>
      <div id="td-effort-badge"   class="badge-pill-muted"></div>
    </div>
    <div class="info-cell">
      <p class="info-label">Description</p>
      <p id="td-description" class="info-value" style="margin: 0; font-size: 1.4rem; line-height: 1.6;"></p>
    </div>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
      <div class="info-cell"><p class="info-label">Assigned By</p><p id="td-assigner" class="info-value" style="font-size: 0.95rem"></p></div>
      <div class="info-cell"><p class="info-label">Created</p><p id="td-created" class="info-value" style="font-size: 0.95rem"></p></div>
      <div class="info-cell"><p class="info-label">Due Date</p><p id="td-due" class="info-value" style="font-size: 0.95rem"></p></div>
      <div class="info-cell"><p class="info-label">Effort</p><p id="td-effort-label" class="info-value" style="font-size: 0.95rem"></p></div>
    </div>
    <div>
      <p class="info-label" style="margin-bottom: 12px;">Progress</p>
      <div style="display: flex; gap: 10px;">
        <div id="td-stage-1" class="stage-bar rounded-pill"></div>
        <div id="td-stage-2" class="stage-bar rounded-pill"></div>
        <div id="td-stage-3" class="stage-bar rounded-pill"></div>
        <div id="td-stage-4" class="stage-bar rounded-pill"></div>
      </div>
      <div style="display: flex; justify-content: space-between; margin-top: 8px;">
        <small class="modal-subtitle" style="font-size:1.1rem;">Not Started</small>
        <small class="modal-subtitle" style="font-size:1.1rem;">In Progress</small>
        <small class="modal-subtitle" style="font-size:1.1rem;">Awaiting Validation</small>
        <small class="modal-subtitle" style="font-size:1.1rem;">Completed</small>
      </div>
    </div>
  </div>
</div>
</div>

<div style="height: 0.2rem;"></div>

</body>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<script>
  const screens = document.querySelectorAll('.carousel-screen');
  const dotsContainer = document.getElementById('carousel-dots');
  const counter = document.getElementById('carousel-counter');
  const title = document.getElementById('carousel-title');
  let current = 0;



  const graphDescriptions = {
  0: {
    title: 'Effort Estimation',
    body:  'Tracks cumulative effort points assigned to you over time. Each point on the line represents a date where one or more tasks were created, showing how your total workload has grown.'
  },
  1: {
    title: '% Progress',
    body:  'Displays completed vs remaining tasks for each project as a bar chart. Green bars show completed tasks, red bars show what is still incomplete.'
  },
  2: {
    title: 'Task Dependencies',
    body:  'Shows how your tasks relate to one another. Nodes represent tasks or clusters of tasks, and arrows indicate which tasks must be completed before others can begin. The further right the task node is, the more dependent on other tasks it is.'
  }
};
// CAROUSEL
function changeScreen(index) {
  const screens = document.querySelectorAll('.carousel-screen');
  const buttons = document.querySelectorAll('.pill-btn');

  screens.forEach(s => s.classList.remove('active'));
  buttons.forEach(b => b.classList.remove('active'));

  screens[index].classList.add('active');
  buttons[index].classList.add('active');

  const desc = graphDescriptions[index];
  document.querySelector('#graph-info-popup .popup-title').textContent = desc.title;
  document.querySelector('#graph-info-popup .popup-body').textContent  = desc.body;
}

// get colour for progress bar
function getStageColour(status, stage) {
  const stageMap = {
    'Not Started':         1,
    'In Progress':         2,
    'Awaiting Validation': 3,
    'Completed':           4,
  };

  const stageColours = {
    1: '#ff3131',
    2: '#ffc107',
    3: '#4f8ef7',
    4: '#28a745',
  };

  const currentStage = stageMap[status] ?? 0;
  const inactiveColour = document.body.classList.contains('dark-mode') ? '#474e5f' : '#999999';
  return stage <= currentStage ? stageColours[currentStage] : inactiveColour;}


// self explanatory
async function getAllTasksByEmployee(tempEmployeeId) {
  const response = await fetch(`<?= BASE_URL ?>api/get_all_tasks_by_employee.php?employee_id=${tempEmployeeId}`);
  const result = await response.json();
  if (!result.success) {
    throw new Error(result.error);
  }
  return result.data.tasks;
}

async function updateTaskStatus(taskId, status, changedByEmployeeId) {
  const response = await fetch('<?= BASE_URL ?>api/update_task_status.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      task_id: taskId,
      status: status,
      changed_by_employee_id: changedByEmployeeId
    })
  });

  // Read as text first so you can inspect it before parsing
  const text = await response.text();
  console.log('Raw API response:', text); // <-- check the browser console

  let result;
  try {
    result = JSON.parse(text);
  } catch (e) {
    throw new Error(`Server returned non-JSON response: ${text.substring(0, 200)}`);
  }

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data;
}

const STATUS_ORDER = ['Not Started', 'In Progress', 'Awaiting Validation', 'Completed'];


function getNextStatuses(currentStatus) {
  const idx = STATUS_ORDER.indexOf(currentStatus);
  if (idx === -1 || currentStatus === 'Completed') return [];

  return STATUS_ORDER.slice(idx + 1).filter(s => {

    if (s === 'Completed' && currentStatus !== 'Awaiting Validation') return false;

    return true;
  });
}

function buildTaskCards(tasks) {
  const container = document.getElementById('tasks-container');
  container.innerHTML = '';

  if (tasks.length === 0) {
    container.innerHTML = `<p style="color:#5a6070; font-size:0.85rem; margin-top:16px;">No tasks match your search.</p>`;
    return;
  }

  tasks = tasks.filter(task => task.task_type === 'project');


  document.addEventListener('click', () => {
    document.querySelectorAll('.status-dropdown').forEach(d => d.remove());
  }, { capture: true });

  tasks.forEach(task => {
    const card = document.createElement('div');
    card.className = 'inner-container rounded-4 py-3 px-3 mt-1';
    card.style.cursor = 'pointer';
    card.addEventListener('click', () => openTaskDetailModal(task));
    card.dataset.title = task.title.toLowerCase();

    const nextStatuses = getNextStatuses(task.status);
    const badgeBg = (statusBadgeStyle[task.status] ?? { bg: 'rgba(255,255,255,0.08)' }).bg;
    const badgeColor = (statusBadgeStyle[task.status] ?? { color: '#a0aabf' }).color;

    card.innerHTML = `
      <div style="display:flex; flex-direction:column; gap:6px;">
        <!-- Row 1: Task name + Due date -->
        <div style="display:flex; justify-content:space-between; align-items:center; gap:8px;">
          <h5 class="m-0" style="font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${task.title}</h5>
          <small style="color:#a0aabf; white-space:nowrap; flex-shrink:0;">Due ${task.due_date}</small>
        </div>
        <!-- Row 2: Priority + Effort pills (left) + Status pill (right) -->
        <div style="display:flex; justify-content:space-between; align-items:center; gap:6px;">
          <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
            <span style="padding:3px 10px; border-radius:999px; font-size:0.72rem; font-weight:700; white-space:nowrap;
              background:${(priorityBadgeStyle[task.priority] ?? { bg: 'rgba(255,255,255,0.08)' }).bg};
              color:${(priorityBadgeStyle[task.priority] ?? { color: '#a0aabf' }).color};">
              ${task.priority ? `${task.priority} Priority` : 'Priority'}
            </span>
            <span style="padding:3px 10px; border-radius:999px; font-size:0.72rem; font-weight:600; white-space:nowrap;
              background:rgba(255,255,255,0.06); color:#a0aabf;">
              Effort ${task.estimated_effort}
            </span>
          </div>
          <!-- Status pill — clickable only if transitions exist -->
          <span
            class="status-pill"
            data-task-id="${task.task_id}"
            style="
              position:relative;
              padding:3px 10px;
              border-radius:999px;
              font-size:0.72rem;
              font-weight:700;
              white-space:nowrap;
              flex-shrink:0;
              background:${badgeBg};
              color:${badgeColor};
              ${nextStatuses.length > 0 ? 'cursor:pointer; user-select:none;' : ''}
            "
          >
            ${task.status}${nextStatuses.length > 0 ? ' ▾' : ''}
          </span>
        </div>
      </div>
    `;

    if (nextStatuses.length > 0) {
      const pill = card.querySelector('.status-pill');
      pill.addEventListener('click', (e) => {
        e.stopPropagation();

        // Remove any existing dropdowns
        document.querySelectorAll('.status-dropdown').forEach(d => d.remove());


        const isDark = document.body.classList.contains('dark-mode');
        // Build dropdown
        const dropdown = document.createElement('div');
        dropdown.className = 'status-dropdown';
        dropdown.style.cssText = `
          position: absolute;
          z-index: 9999;
          background: ${isDark ? '#1e2130' : '#ffffff'};
          border: 1px solid ${isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.08)'};
          border-radius: 8px;
          padding: 4px;
          box-shadow: 0 8px 24px ${isDark ? 'rgba(0,0,0,0.4)' : 'rgba(0,0,0,0.12)'};
          min-width: 160px;
        `;
        



          nextStatuses.forEach(status => {
            const option = document.createElement('button');

            const optBg = (statusBadgeStyle[status] ?? { bg: isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,1)' }).bg;
          const optColor = (statusBadgeStyle[status] ?? { color: '#a0aabf' }).color;
          option.style.cssText = `
            display:block;
            width:100%;
            text-align:left;
            padding:6px 10px;
            border:none;
            background:transparent;
            border-radius:6px;
            cursor:pointer;
            font-size:0.72rem;
            font-weight:700;
            color:${optColor};
          `;
          option.innerHTML = `<span style="
            display:inline-block;
            padding:2px 8px;
            border-radius:999px;
            background:${optBg};
            color:${optColor};
          ">${status}</span>`;

          option.addEventListener('mouseenter', () => option.style.background = 'rgba(255,255,255,0.06)');
          option.addEventListener('mouseleave', () => option.style.background = 'transparent');

          option.addEventListener('click', async (e) => {
            e.stopPropagation();
            dropdown.remove();

            try {
              const updated = await updateTaskStatus(task.task_id, status, employeeId);
              // Update the local task object with the response
              task.status = updated.new_status;
              task.started_date = updated.started_date;
              task.submitted_date = updated.submitted_date;
              task.completed_date = updated.completed_date;
              task.completed_by_id = updated.completed_by_id;
              task.completion_wait_time = updated.completion_wait_time;
              // Re-render cards to reflect new status
              buildTaskCards(tasks);
              renderTaskStatusChart(tempEmployeeId);
              renderProjectProgressChart(tempEmployeeId);
            } catch (err) {
              alert(`Could not update status: ${err.message}`);
            }
          });

          dropdown.appendChild(option);
        });

        // Position dropdown below the pill
        const pillRect = pill.getBoundingClientRect();
        dropdown.style.position = 'fixed';
        dropdown.style.top = `${pillRect.bottom + 4}px`;
        dropdown.style.left = `${pillRect.left}px`;

        document.body.appendChild(dropdown);
      });
    }

    container.appendChild(card);
  });

  renderDependencyGraph(tasks);
}

// parses in the filtered query 
function filterTasks(query) {
  const q = query.trim().toLowerCase();
  if (!cachedTasks) return;

  let results = q === '' ? cachedTasks : cachedTasks.filter(t => t.title.toLowerCase().includes(q));
  results = getSortedTasks(results);
  buildTaskCards(results);
}

function getPriorityColour(priority) {
  switch (priority) {
    case 'High':   return '#ff3131';
    case 'Medium': return '#ffc107';
    case 'Low':    return '#28a745';
    default:       return '#6c757d';
  }
}


// DONUT CHART START!!!
// this is where im up to in commenting this page ill get round to it at some point 🔥

  let taskStatusChart;

  const statusColors = {
    'Completed': '#28a745',
    'In Progress': '#ffc107',
    'Awaiting Validation': '#4f8ef7',
    'Not Started': '#ff3131',
  };


  const centerTextPlugin = {
    id: 'centerTextPlugin',
    beforeDraw(chart) {
      const { ctx, chartArea } = chart;
      const completed = chart.completedCount || 0;

      ctx.save();
      ctx.font = '700 34px Lexend Deca, sans-serif';
      ctx.fillStyle = '#8ba6e0';
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';

      const x = (chartArea.left + chartArea.right) / 2;
      const y = (chartArea.top + chartArea.bottom) / 2;

      ctx.fillText(completed.toString(), x, y - 8);

      ctx.font = '400 28px Lexend Deca, sans-serif';
      ctx.fillStyle = '#596785';
      ctx.fillText('Completed', x, y + 18);

      ctx.restore();
    }
  };

  async function renderTaskStatusChart(tempEmployeeId) {
    try {
      const tasks = await getAllTasksByEmployee(tempEmployeeId);

      const counts = {
        'Completed': 0,
        'Awaiting Validation': 0,
        'In Progress': 0,
        'Not Started': 0,
      };

      tasks.forEach(task => {
        if (counts.hasOwnProperty(task.status)) {
          counts[task.status]++;
        } else {
          counts['Not Started']++;
        }
      });

      const labels = Object.keys(counts).filter(status => counts[status] > 0);
      const data = labels.map(status => counts[status]);
      const colors = labels.map(status => statusColors[status]);
      const completedCount = counts['Completed'];

      const legendContainer = document.getElementById('task-status-legend');
      legendContainer.innerHTML = '';

      const ul = document.createElement('ul');
      ul.className = 'chart-legend-list';
      ul.style.margin = '0';
      ul.style.paddingLeft = '24px';
      ul.style.fontSize = '1.15rem';
      ul.style.fontWeight = '600';
      ul.style.lineHeight = '2';

      Object.keys(counts).forEach(status => {
        const count = counts[status];

        const li = document.createElement('li');
        li.innerHTML = `&nbsp;${status} <span>: ${count}</span>`;

        ul.appendChild(li);
      });

      legendContainer.appendChild(ul);

      const ctx = document.getElementById('task-status-chart').getContext('2d');

      if (taskStatusChart) {
        taskStatusChart.destroy();
        taskStatusChart = null;
      }

      taskStatusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels,
          datasets: [{data, backgroundColor: colors, borderColor: '#252B3B', borderWidth: 1, hoverOffset: 4}]
        },
        options: {
          responsive: true, maintainAspectRatio: false, cutout: '75%', layout: {padding: 12},
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const label = context.label || '';
                  const value = context.raw || 0;
                  return `${label}: ${value}`;
                }
              }
            }
          }
        },
        plugins: [centerTextPlugin]
      });

      taskStatusChart.completedCount = completedCount;
      taskStatusChart.update();
    } catch (error) {
      console.error('Failed to load task status chart:', error);
    }
  }

  renderTaskStatusChart(tempEmployeeId);

async function renderProjectProgressChart(tempEmployeeId) {
  try {
    const tasks = await getAllTasksByEmployee(tempEmployeeId);

    const effortPoints = { 'XS': 1, 'S': 2, 'M': 3, 'L': 5, 'XL': 8 };

    const projects = {};
    tasks.forEach(task => {
      const name = task.project_name ?? 'Personal Tasks';
      const pts = effortPoints[task.estimated_effort] ?? 3;

      if (!projects[name]) {
        projects[name] = { completed: 0, remaining: 0 };
      }

      if (task.status === 'Completed') {
        projects[name].completed += pts;
      } else {
        projects[name].remaining += pts;
      }
    });

    const labels    = Object.keys(projects);
    const completed = labels.map(p => projects[p].completed);
    const remaining = labels.map(p => projects[p].remaining);

    const canvas = document.getElementById('project-progress-chart');
    const existingChart = Chart.getChart(canvas);
    if (existingChart) existingChart.destroy();

    const ctx = canvas.getContext('2d');

    const isDark        = document.body.classList.contains('dark-mode');
    const tickColor     = isDark ? '#ffffff' : '#333333';
    const gridColor     = isDark ? 'rgba(255,255,255,0.04)' : 'rgba(0,0,0,0.06)';
    const tooltipBg     = isDark ? '#252B3B' : '#ffffff';
    const tooltipBorder = isDark ? '#3a3f4b' : '#ced4da';
    const tooltipTitle  = isDark ? '#e8ecf5' : '#111111';
    const tooltipBody   = isDark ? '#a0aabf' : '#555555';

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels,
        datasets: [
          {
            label: 'Completed',
            barPercentage: 0.4,
            categoryPercentage: 0.5,
            data: completed,
            backgroundColor: 'rgba(40, 167, 69, 0.85)',
            hoverBackgroundColor: '#28a745',
            borderRadius: { topLeft: 0, topRight: 0, bottomLeft: 8, bottomRight: 8 },
            borderSkipped: false,
            stack: 'tasks'
          },
          {
            label: 'Remaining',
            barPercentage: 0.4,
            categoryPercentage: 0.5,
            data: remaining,
            backgroundColor: 'rgba(255, 49, 49, 0.75)',
            hoverBackgroundColor: '#ff3131',
            borderRadius: { topLeft: 8, topRight: 8, bottomLeft: 0, bottomRight: 0 },
            borderSkipped: false,
            stack: 'tasks'
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: tooltipBg,
            borderColor: tooltipBorder,
            borderWidth: 1,
            titleColor: tooltipTitle,
            bodyColor: tooltipBody,
            titleFont: { family: 'Lexend Deca', weight: '600', size: 26 },
            bodyFont: { family: 'Lexend Deca', size: 24 },
            padding: 24,
            callbacks: {
              title: items => items[0].label,
              label: ctx => {
                const isComplete = ctx.datasetIndex === 0;
                return ` ${ctx.parsed.y} pts ${isComplete ? 'completed' : 'remaining'}`;
              }
            }
          }
        },
        scales: {
          x: {
            stacked: true,
            grid: { display: false },
            border: { display: false },
            title: {
              display: true,
              text: 'Projects',
              color: tickColor,
              font: { family: 'Lexend Deca', size: 20, weight: '700' },
              padding: { top: 10 }
            },
            ticks: { color: tickColor, font: { family: 'Lexend Deca', size: 15 }, maxRotation: 25 }
          },
          y: {
            stacked: true,
            grid: { color: gridColor },
            border: { display: false },
            title: {
              display: true,
              text: 'Estimated Effort',
              color: tickColor,
              font: { family: 'Lexend Deca', size: 20, weight: '700' },
              padding: { bottom: 10 }
            },
            ticks: {
              color: tickColor,
              font: { family: 'Lexend Deca', size: 15 },
              stepSize: 1,
              callback: v => `${v} pts`
            }
          }
        }
      }
    });

  } catch (error) {
    console.error('Failed to render project progress chart:', error);
  }
}

renderProjectProgressChart(tempEmployeeId);

//
// GIANT CODE BLOCK FOR TASK DEPENDENCY GRAPH
//

const effortOrder = { 'XS': 1, 'S': 2, 'M': 3, 'L': 4, 'XL': 5 };
const effortTicks = ['XL', 'L', 'M', 'S', 'XS'];

function renderDependencyGraph(tasks) {
  const container = document.getElementById('dependency-graph');
  container.innerHTML = '';

  const W = 1600;
  const H = 580;

  // Detect mode
  const isDark         = document.body.classList.contains('dark-mode');
  const tickColor      = isDark ? '#ffffff' : '#333333';
  const gridStroke     = isDark ? '#2a2f3b' : '#d0d5dd';
  const axisArrow      = isDark ? '#ffffff' : '#333333';
  const linkStroke     = isDark ? '#ffffff' : '#555555';
  const tooltipBg      = isDark ? '#111723' : '#ffffff';
  const tooltipBorder  = isDark ? '#3a3f4b' : '#ced4da';
  const tooltipHeading = isDark ? '#ffffff' : '#111111';
  const tooltipText    = isDark ? '#e8ecf5' : '#222222';
  const tooltipMuted   = isDark ? '#a0aabf' : '#555555';
  const nodeBg         = isDark ? '#252B3B' : '#f4f5f7';
  const nodeHoverBg    = isDark ? '#2d3448' : '#e8eaf0';
  const nodeTitleColor = isDark ? '#e8ecf5' : '#111111';
  const nodeMutedColor = isDark ? '#a0aabf' : '#555555';

  const nodeMap = {};

  tasks.forEach(t => {
    nodeMap[t.task_id] = { id: t.task_id, title: t.title, status: t.status, effort: t.estimated_effort, isMain: true };
  });

  tasks.forEach(t => {
    (t.dependencies || []).forEach(d => {
      if (!nodeMap[d.dependency_id]) {
        nodeMap[d.dependency_id] = { id: d.dependency_id, title: d.dependency_title, status: d.dependency_status, effort: null, isMain: false };
      }
    });
  });

  const nodes = Object.values(nodeMap);

  const links = [];
  tasks.forEach(t => {
    (t.dependencies || []).forEach(d => {
      links.push({ source: d.dependency_id, target: t.task_id });
    });
  });

  const depthMap = {};
  const depsList = {};

  nodes.forEach(n => { depsList[n.id] = []; });

  tasks.forEach(t => {
    (t.dependencies || []).forEach(d => {
      if (!depsList[t.task_id]) depsList[t.task_id] = [];
      depsList[t.task_id].push(d.dependency_id);
    });
  });

  function getDepth(id, visited = new Set()) {
    if (depthMap[id] !== undefined) return depthMap[id];
    if (visited.has(id)) return 0;

    visited.add(id);
    const deps = depsList[id] || [];

    if (deps.length === 0) {
      depthMap[id] = 0;
    } else {
      depthMap[id] = Math.max(...deps.map(depId => getDepth(depId, new Set(visited)))) + 1;
    }

    return depthMap[id];
  }

  nodes.forEach(n => getDepth(n.id));

  const effortRanks = { 'XS': 0, 'S': 1, 'M': 2, 'L': 3, 'XL': 4 };
  const colLevels = [...new Set(nodes.map(n => depthMap[n.id] ?? 0))].sort((a, b) => a - b);

  const margin = { top: 30, right: 60, bottom: 50, left: 60 };
  const innerW = W - margin.left - margin.right;
  const innerH = H - margin.top - margin.bottom;

  const svg = d3.select(container)
    .append('svg')
    .attr('width', '100%')
    .attr('height', H)
    .attr('viewBox', `0 0 ${W} ${H}`);

  const g = svg.append('g')
    .attr('transform', `translate(${margin.left}, ${margin.top})`);

  const yScale = d3.scalePoint()
    .domain(effortTicks)
    .range([0, innerH])
    .padding(0.5);

  const colW = innerW / (colLevels.length + 1);

  const statusColour = {
    'Completed':           '#28a745',
    'In Progress':         '#ffc107',
    'Awaiting Validation': '#4f8ef7',
    'Not Started':         '#ff3131',
  };

  function getColour(status) {
    return statusColour[status] ?? '#6c757d';
  }

  const yAxis = d3.axisLeft(yScale)
    .tickSize(-innerW)
    .tickPadding(8);

  g.append('g')
    .attr('class', 'y-axis')
    .call(yAxis)
    .call(ax => ax.select('.domain').remove())
    .call(ax => ax.selectAll('.tick line')
      .attr('stroke', gridStroke)
      .attr('stroke-dasharray', '4,3'))
    .call(ax => ax.selectAll('.tick text')
      .attr('fill', tickColor)
      .attr('font-size', '15px')
      .attr('font-family', 'Lexend Deca, sans-serif')
      .attr('font-weight', '700'));

    g.append('text')
      .attr('transform', `translate(${-margin.left + 10}, ${innerH / 2}) rotate(-90)`)
      .attr('text-anchor', 'middle')
      .attr('fill', tickColor)
      .attr('font-size', '18px')
      .attr('font-family', 'Lexend Deca, sans-serif')
      .attr('font-weight', '700')
      .text('Estimated Effort');

  const xAxis = d3.axisTop(
    d3.scalePoint().domain(colLevels.map(String)).range([0, innerW])
  )
    .tickSize(0)
    .tickFormat('');

  g.append('g')
    .attr('class', 'x-axis')
    .call(xAxis)
    .call(ax => ax.select('.domain').attr('stroke', gridStroke));

  const xLabelGroup = g.append('g')
    .attr('transform', `translate(0, ${innerH + 36})`);

  xLabelGroup.append('line')
    .attr('x1', 0)
    .attr('y1', 0)
    .attr('x2', innerW - 8)
    .attr('y2', 0)
    .attr('stroke', axisArrow)
    .attr('stroke-width', 1.5)
    .attr('marker-end', 'url(#arrow)');

  xLabelGroup.append('text')
    .attr('x', innerW / 2)
    .attr('y', -8)
    .attr('fill', tickColor)
    .attr('font-size', '15px')
    .attr('font-family', 'Lexend Deca, sans-serif')
    .attr('font-weight', '700')
    .attr('text-anchor', 'middle')
    .text('More Dependent');

  svg.append('defs').append('marker')
    .attr('id', 'arrow')
    .attr('viewBox', '0 -5 10 10')
    .attr('refX', 10)
    .attr('refY', 0)
    .attr('markerWidth', 20)
    .attr('markerHeight', 20)
    .attr('orient', 'auto')
    .append('path')
    .attr('d', 'M0,-5L10,0L0,5')
    .attr('fill', axisArrow);

  svg.append('defs').append('marker')
    .attr('id', 'arrow-white')
    .attr('viewBox', '0 -5 10 10')
    .attr('refX', 0)
    .attr('refY', 0)
    .attr('markerWidth', 7)
    .attr('markerHeight', 7)
    .attr('orient', 'auto')
    .append('path')
    .attr('d', 'M0,-5L10,0L0,5')
    .attr('fill', linkStroke);

  const clusterMap = new Map();

  nodes.forEach(n => {
    const col = depthMap[n.id] ?? 0;
    const effortLabel = effortTicks.includes(n.effort) ? n.effort : 'M';
    const key = `${col}__${effortLabel}`;

    if (!clusterMap.has(key)) {
      clusterMap.set(key, {
        key, col, effort: effortLabel,
        x: colW * (col + 1),
        y: yScale(effortLabel),
        items: [],
      });
    }

    clusterMap.get(key).items.push(n);
  });

  const renderNodes = [...clusterMap.values()].map(cluster => {
    const items = cluster.items.sort((a, b) => {
      const effortDiff = (effortRanks[a.effort] ?? 2) - (effortRanks[b.effort] ?? 2);
      if (effortDiff !== 0) return effortDiff;
      return a.title.localeCompare(b.title);
    });

    const primary = items[0];

    return {
      id: cluster.key,
      x: cluster.x,
      y: cluster.y,
      col: cluster.col,
      effort: cluster.effort,
      items,
      isCluster: items.length > 1,
      count: items.length,
      title: primary.title,
      status: primary.status,
      colour: getColour(primary.status),
    };
  });

  const posMap = {};
  renderNodes.forEach(rn => {
    rn.items.forEach(item => {
      posMap[item.id] = rn;
    });
  });

  // --- Tooltip ---
  const tooltip = d3.select(container)
    .append('div')
    .style('position', 'absolute')
    .style('pointer-events', 'none')
    .style('opacity', 0)
    .style('background', tooltipBg)
    .style('border', `1px solid ${tooltipBorder}`)
    .style('border-radius', '18px')
    .style('padding', '18px 21px')
    .style('color', tooltipText)
    .style('font-family', 'Lexend Deca, sans-serif')
    .style('font-size', '18px')
    .style('line-height', '1.5')
    .style('max-width', '390px')
    .style('box-shadow', '0 10px 30px rgba(0,0,0,0.35)')
    .style('z-index', 20);

  container.style.position = 'relative';

  // --- Draw links ---
  g.selectAll('.dep-link')
    .data(links)
    .enter()
    .append('polyline')
    .attr('class', 'dep-link')
    .attr('points', d => {
      const x1 = posMap[d.source]?.x ?? 0;
      const y1 = posMap[d.source]?.y ?? 0;
      const x2 = posMap[d.target]?.x ?? 0;
      const y2 = posMap[d.target]?.y ?? 0;
      const mx = (x1 + x2) / 2;
      const my = (y1 + y2) / 2;
      return `${x1},${y1} ${mx},${my} ${x2},${y2}`;
    })
    .attr('fill', 'none')
    .attr('stroke', linkStroke)
    .attr('stroke-width', 1.5)
    .attr('stroke-dasharray', '5,3')
    .attr('marker-mid', 'url(#arrow-white)')
    .attr('marker-end', 'url(#arrow-white)')
    .attr('opacity', 0)
    .transition()
    .duration(600)
    .delay((_, i) => i * 40)
    .attr('opacity', 1);

  const nodeW = 200;
  const singleH = 70;
  const clusterH = 86;

  const nodeG = g.selectAll('.dep-node')
    .data(renderNodes)
    .enter()
    .append('g')
    .attr('class', 'dep-node')
    .attr('transform', d => {
      const h = d.isCluster ? clusterH : singleH;
      return `translate(${d.x - nodeW / 2}, ${d.y - h / 2})`;
    })
    .style('cursor', d => d.isCluster ? 'pointer' : 'default')
    .attr('opacity', 0);

  nodeG.transition()
    .duration(500)
    .delay((_, i) => i * 50)
    .attr('opacity', 1);

  nodeG.append('rect')
    .attr('width', nodeW)
    .attr('height', d => d.isCluster ? clusterH : singleH)
    .attr('rx', 14)
    .attr('ry', 14)
    .attr('fill', nodeBg)
    .attr('stroke', d => d.colour)
    .attr('stroke-width', 1.5);

  nodeG.each(function(d) {
    const group = d3.select(this);

    if (d.isCluster) {
      group.append('text')
        .attr('x', 20)
        .attr('y', 26)
        .attr('fill', nodeTitleColor)
        .attr('font-size', '18px')
        .attr('font-family', 'Lexend Deca, sans-serif')
        .attr('font-weight', '700')
        .text(`${d.count} tasks`);

      group.append('text')
        .attr('x', 20)
        .attr('y', 48)
        .attr('fill', nodeMutedColor)
        .attr('font-size', '15px')
        .attr('font-family', 'Lexend Deca, sans-serif')
        .text('Hover to view tasks');

      group.append('text')
        .attr('x', 20)
        .attr('y', 68)
        .attr('fill', d.colour)
        .attr('font-size', '16px')
        .attr('font-family', 'Lexend Deca, sans-serif')
        .text(`Effort: ${d.effort}`);
    } else {
      group.append('text')
        .attr('x', 20)
        .attr('y', 26)
        .attr('fill', nodeTitleColor)
        .attr('font-size', '13px')
        .attr('font-family', 'Lexend Deca, sans-serif')
        .attr('font-weight', '600')
        .text(d.title.length > 22 ? d.title.slice(0, 22) + '…' : d.title);

      group.append('text')
        .attr('x', 20)
        .attr('y', 46)
        .attr('fill', getColour(d.status))
        .attr('font-size', '11px')
        .attr('font-family', 'Lexend Deca, sans-serif')
        .text(d.status);
    }
  });

  nodeG
    .on('mouseenter', function(event, d) {
      if (!d.isCluster) return;

      d3.select(this).select('rect')
        .transition()
        .duration(150)
        .attr('fill', nodeHoverBg)
        .attr('stroke-width', 2);

      const html = `
        <div style="font-weight:700; margin-bottom:12px; color:${tooltipHeading}; font-size:18px;">
          ${d.count} tasks in this cluster
        </div>
        <div style="display:flex; flex-direction:column; gap:9px;">
          ${d.items.map(item => `
            <div>
              <div style="color:${tooltipText}; font-size:18px;">${escapeHtml(item.title)}</div>
              <div style="color:${getColour(item.status)}; font-size:16px;">
                ${escapeHtml(item.status || 'Unknown')}
              </div>
            </div>
          `).join('')}
        </div>
      `;

      tooltip.html(html).style('opacity', 1);
    })
    .on('mousemove', function(event, d) {
      if (!d.isCluster) return;

      const [mx, my] = d3.pointer(event, container);
      const tooltipNode = tooltip.node();
      const tw = tooltipNode.offsetWidth;
      const th = tooltipNode.offsetHeight;
      const cw = container.offsetWidth;
      const ch = container.offsetHeight;

      const x = Math.min(mx + 16, cw - tw - 8);
      const y = Math.min(my + 16, ch - th - 8);

      tooltip
        .style('left', `${Math.max(8, x)}px`)
        .style('top', `${Math.max(8, y)}px`);
    })
    .on('mouseleave', function(event, d) {
      if (!d.isCluster) return;

      d3.select(this).select('rect')
        .transition()
        .duration(150)
        .attr('fill', nodeBg)
        .attr('stroke-width', 1.5);

      tooltip.style('opacity', 0);
    });

  function escapeHtml(str = '') {
    return String(str)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#39;');
  }
}


const effortPoints = { 'XS': 1, 'S': 4, 'M': 8, 'L': 24, 'XL': 40 };

async function renderEffortEstimationChart(tempEmployeeId) {
  try {
    const tasks = await getAllTasksByEmployee(tempEmployeeId);

    const sorted = [...tasks]
      .filter(t => t.created_date || t.due_date)
      .sort((a, b) => new Date(a.created_date ?? a.due_date) - new Date(b.created_date ?? b.due_date));

    let runningTotal = 0;
    const dateMap = new Map();

    sorted.forEach(task => {
      const pts = effortPoints[task.estimated_effort] ?? 3;
      runningTotal += pts;
      const raw = task.created_date ?? task.due_date;
      const dateStr = raw.replace('T', ' ').split(' ')[0];

      if (dateMap.has(dateStr)) {
        const entry = dateMap.get(dateStr);
        entry.y = runningTotal;
        entry.titles.push(task.title);
        entry.pts += pts;
        entry.efforts.push(task.estimated_effort ?? 'M');
      } else {
        dateMap.set(dateStr, {
          y: runningTotal,
          titles: [task.title],
          pts,
          efforts: [task.estimated_effort ?? 'M'],
        });
      }
    });

    const entries = [...dateMap.entries()].sort(([a], [b]) => a.localeCompare(b));

    function isoToMs(isoStr) {
      const [y, m, d] = isoStr.split('-').map(Number);
      return new Date(y, m - 1, d, 12).getTime();
    }

    function fmtMs(ms) {
      const d = new Date(ms);
      return d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
    }

    const firstMs = isoToMs(entries[0][0]);
    const baselineMs = firstMs - 86400000;

    const chartMeta = [
      { x: baselineMs, y: 0, isBaseline: true },
      ...entries.map(([date, d]) => ({
        x: isoToMs(date),
        y: d.y,
        isBaseline: false,
        titles: d.titles,
        pts: d.pts,
        efforts: d.efforts,
      })),
    ];

    const canvas = document.getElementById('effort-estimation-chart');

    // Destroy existing Chart.js instance if one exists on this canvas
    const existingChart = Chart.getChart(canvas);
    if (existingChart) existingChart.destroy();

    const ctx = canvas.getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(238, 169, 52, 0.22)');
    gradient.addColorStop(1, 'rgba(238, 169, 52, 0.00)');

    const isDark        = document.body.classList.contains('dark-mode');
    const tickColor     = isDark ? '#ffffff' : '#333333';
    const gridColor     = isDark ? 'rgba(255,255,255,0.04)' : 'rgba(0,0,0,0.06)';
    const tooltipBg     = isDark ? '#252B3B' : '#ffffff';
    const tooltipBorder = isDark ? '#3a3f4b' : '#ced4da';
    const tooltipTitle  = isDark ? '#e8ecf5' : '#111111';
    const tooltipBody   = isDark ? '#a0aabf' : '#555555';
    const pointBorder   = isDark ? '#1C2131' : '#ffffff';

    new Chart(ctx, {
      type: 'line',
      data: {
        datasets: [{
          label: 'Cumulative Effort',
          data: chartMeta.map(d => ({ x: d.x, y: d.y })),
          metaPoints: chartMeta,
          borderColor: '#eea934',
          borderWidth: 2.5,
          stepped: 'before',
          pointRadius: chartMeta.map(d => d.isBaseline ? 0 : 6),
          pointHoverRadius: chartMeta.map(d => d.isBaseline ? 0 : 9),
          pointBackgroundColor: '#eea934',
          pointBorderColor: pointBorder,
          pointBorderWidth: 2.5,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 900, easing: 'easeOutQuart' },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: tooltipBg,
            borderColor: tooltipBorder,
            borderWidth: 1,
            titleColor: tooltipTitle,
            bodyColor: tooltipBody,
            titleFont: { family: 'Lexend Deca', weight: '600', size: 26 },
            bodyFont: { family: 'Lexend Deca', size: 24 },
            padding: 28,
            displayColors: false,
            filter: item => {
              const meta = item.dataset.metaPoints?.[item.dataIndex];
              return meta && !meta.isBaseline;
            },
            callbacks: {
              title: items => {
                if (!items || !items.length) return '';
                const meta = items[0].dataset.metaPoints?.[items[0].dataIndex];
                return (!meta || meta.isBaseline) ? '' : fmtMs(meta.x);
              },
              label: context => {
                if (!context) return '';
                const meta = context.dataset.metaPoints?.[context.dataIndex];
                if (!meta || meta.isBaseline) return '';
                const taskLines = meta.titles.map((t, i) => ` • ${t.length > 28 ? t.slice(0, 28) + '…' : t}  ·  ${meta.efforts[i]}`);
                return [` +${meta.pts} pts  |  Total: ${meta.y} pts`, '', ...taskLines];
              }
            }
          }
        },
        scales: {
          x: {
            type: 'linear',
            min: baselineMs,
            max: chartMeta[chartMeta.length - 1].x + 86400000,
            afterBuildTicks: axis => {
              axis.ticks = chartMeta
                .filter(d => !d.isBaseline)
                .map(d => ({ value: d.x }));
            },
            grid: { display: false },
            border: { display: false },
            title: {
              display: true,
              text: 'Date',
              color: tickColor,
              font: { family: 'Lexend Deca', size: 20, weight: '700' },
              padding: { top: 10 }
            },
            ticks: { color: tickColor, font: { family: 'Lexend Deca', size: 15 }, maxRotation: 30, autoSkip: false, callback: val => fmtMs(val) }
          },
          y: {
            beginAtZero: true,
            grid: { color: gridColor },
            border: { display: false },
            title: {
              display: true,
              text: 'Cumulative Estimated Effort',
              color: tickColor,
              font: { family: 'Lexend Deca', size: 20, weight: '700' },
              padding: { bottom: 10 }
            },
            ticks: { color: tickColor, font: { family: 'Lexend Deca', size: 15 }, stepSize: 1, callback: v => `${v} pts` }
          }
        }
      }
    });

  } catch (error) {
    console.error('Failed to render effort estimation chart:', error);
  }
}

renderEffortEstimationChart(tempEmployeeId);


let cachedTasks = null;



async function openOverdueModal() {

  if (!cachedTasks) {
    cachedTasks = await getAllTasksByEmployee(tempEmployeeId);
  }

  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const overdue = cachedTasks.filter(task => {
    if (task.status === 'Completed') return false;
    const due = new Date(task.due_date.replace('T', ' ').split(' ')[0] + 'T12:00:00');
    return due < today;
  });

  const list = document.getElementById('overdue-task-list');
  const subtitle = document.getElementById('overdue-subtitle');
  list.innerHTML = '';
  subtitle.textContent = `${overdue.length} task${overdue.length !== 1 ? 's' : ''} past their due date`;

  if (overdue.length === 0) {
    list.innerHTML = `<p style="color: #a0aabf; text-align: center; margin: 24px 0;">No overdue tasks — you're all caught up!</p>`;
  } else {
    overdue.forEach(task => {
      const due = new Date(task.due_date.replace('T', ' ').split(' ')[0] + 'T12:00:00');
      const daysOverdue = Math.floor((today - due) / 86400000);

      const card = document.createElement('div');
      card.className = "inner-container";
      card.style.cssText = `border-radius: 16px; padding: 14px 16px;`;

      card.innerHTML = `
        <div class="d-flex justify-content-between align-items-center gap-3" style="padding: 8px 0;">
          <h5 class="m-0" style="font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-size: 1.9rem;">${task.title}</h5>
          <div class="d-flex align-items-center gap-2" style="flex-shrink: 0;">
            <span style="
              padding: 6px 20px;
              border-radius: 999px;
              font-size: 1.44rem;
              font-weight: 700;
              white-space: nowrap;
              background: ${(statusBadgeStyle[task.status] ?? { bg:'rgba(255,255,255,0.08)' }).bg};
              color: ${(statusBadgeStyle[task.status] ?? { color:'#a0aabf' }).color};
            ">${task.status || '—'}</span>
            <span style="
              padding: 6px 20px;
              border-radius: 999px;
              font-size: 1.44rem;
              font-weight: 700;
              white-space: nowrap;
              background: rgba(255, 49, 49, 0.15);
              color: #ff3131;
            ">${daysOverdue}d overdue</span>
            <small style="color:#a0aabf; white-space:nowrap; font-size: 1.6rem;">Due: ${due.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' })}</small>
          </div>
        </div>
      `;

      list.appendChild(card);
    });
  }

  const backdrop = document.getElementById('overdue-modal-backdrop');
  backdrop.style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function closeOverdueModal() {
  document.getElementById('overdue-modal-backdrop').style.display = 'none';
  document.body.style.overflow = '';
}


document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeOverdueModal();
});

const CAPACITY_PTS = 6;
let utilisationChartInstance = null;

function getWeekKey(dateStr) {

  const [y, m, d] = dateStr.split('-').map(Number);
  const date = new Date(y, m - 1, d, 12);
  const day = date.getDay();
  const diff = (day === 0 ? -6 : 1 - day);
  const monday = new Date(date);
  monday.setDate(date.getDate() + diff);
  return monday.toISOString().split('T')[0]; 
}

function fmtWeekLabel(mondayIso) {
  const [y, m, d] = mondayIso.split('-').map(Number);
  const monday = new Date(y, m - 1, d, 12);
  const sunday = new Date(monday);
  sunday.setDate(monday.getDate() + 6);
  const fmt = date => date.toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
  return `${fmt(monday)} – ${fmt(sunday)}`;
}

function getChartThemeColors() {
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark'
    || (window.matchMedia('(prefers-color-scheme: dark)').matches
        && !document.documentElement.getAttribute('data-theme'));
  return {
    title:    isDark ? '#a0aabf' : '#5a6070',
    ticks:    isDark ? '#6b7280' : '#5a6070',
    grid:     isDark ? 'rgba(255,255,255,0.08)' : 'rgba(136,136,136,0.2)',
    capLine:  isDark ? 'rgba(255,255,255,0.25)' : 'rgba(136,136,136,0.5)',
    capText:  isDark ? 'rgba(255,255,255,0.25)' : 'rgba(136,136,136,0.5)',
  };
}

async function openUtilisationModal() {
  if (!cachedTasks) {
    cachedTasks = await getAllTasksByEmployee(tempEmployeeId);
  }

  const t = getChartThemeColors();
  const weekMap = new Map();

  cachedTasks.forEach(task => {
    if (!task.due_date) return;
    const dateStr = task.due_date.replace('T', ' ').split(' ')[0];
    const weekKey = getWeekKey(dateStr);
    const pts = effortPoints[task.estimated_effort] ?? 3;
    weekMap.set(weekKey, (weekMap.get(weekKey) ?? 0) + pts);
  });


  const sortedWeeks = [...weekMap.entries()].sort(([a], [b]) => a.localeCompare(b));


  const labels = sortedWeeks.map(([w]) => fmtWeekLabel(w));
  const utilisationPcts = sortedWeeks.map(([, pts]) =>
    Math.round((pts / CAPACITY_PTS) * 100)
  );


  const barColors = utilisationPcts.map(pct => {
    if (pct > 100) return 'rgba(255, 49, 49, 0.85)';
    if (pct >= 80)  return 'rgba(40, 167, 69, 0.85)';
    return 'rgba(79, 142, 247, 0.85)';
  });

  const hoverColors = utilisationPcts.map(pct => {
    if (pct > 100) return '#ff3131';
    if (pct >= 80)  return '#28a745';
    return '#4f8ef7';
  });


  if (utilisationChartInstance) {
    utilisationChartInstance.destroy();
    utilisationChartInstance = null;
  }

  const ctx = document.getElementById('utilisation-chart').getContext('2d');
utilisationChartInstance = new Chart(ctx, {
  type: 'bar',
  data: { labels, datasets: [{ label: 'Utilisation %', data: utilisationPcts,
    backgroundColor: barColors, hoverBackgroundColor: hoverColors,
    borderRadius: 8, borderSkipped: false, barPercentage: 0.5, categoryPercentage: 0.6 }] },
  options: {
    responsive: true, maintainAspectRatio: false,
    animation: { duration: 700, easing: 'easeOutQuart' },
    plugins: { legend: { display: false },
      tooltip: { backgroundColor: '#1C2131', borderColor: '#3a3f4b', borderWidth: 1,
        titleColor: '#e8ecf5', bodyColor: '#a0aabf',
        titleFont: { family: 'Lexend Deca', weight: '600', size: 14 },
        bodyFont: { family: 'Lexend Deca', size: 14 }, padding: 14, displayColors: false,
        callbacks: { title: items => items[0].label,
          label: context => { const pct=context.parsed.y; const pts=sortedWeeks[context.dataIndex][1]; const status=pct>100?'Over utilised':pct>=80?'Optimal':'Under utilised'; return [` ${pct}% utilisation`, ` ${pts} / ${CAPACITY_PTS} pts assigned`, ` ${status}`]; } } } },

    // the axis
    scales: {
          x: {
            grid: { display: false },
            border: { display: false },
            title: {
              display: true,
              text: 'Week',
              color: t.title,
              font: { family: 'Lexend Deca', size: 18, weight: '600' },
              padding: { top: 8 }
            },
            ticks: { color: t.ticks, font: { family: 'Lexend Deca', size: 13 }, maxRotation: 30 }
          },
          y: {
            beginAtZero: true,
            max: Math.max(120, ...utilisationPcts) + 10,
            grid: { color: t.grid },
            border: { display: false },
            title: {
              display: true,
              text: 'Utilisation %',
              color: t.title,
              font: { family: 'Lexend Deca', size: 18, weight: '600' },
              padding: { bottom: 8 }
            },
            ticks: { color: t.ticks, font: { family: 'Lexend Deca', size: 13 }, callback: v => `${v}%` }
          }
        }
      },
      plugins: [{
        id: 'capacityLine',
        afterDraw(chart) {
          const { ctx, chartArea, scales } = chart;
          const y100 = scales.y.getPixelForValue(100);
          ctx.save(); ctx.beginPath();
          ctx.moveTo(chartArea.left, y100); ctx.lineTo(chartArea.right, y100);
          ctx.strokeStyle = t.capLine;
          ctx.lineWidth = 2; ctx.setLineDash([6,4]); ctx.stroke();
          ctx.setLineDash([]);
          ctx.font = '600 13px Lexend Deca, sans-serif';
          ctx.fillStyle = t.capText;
          ctx.textAlign = 'right'; ctx.fillText('100% capacity', chartArea.right-4, y100-8); ctx.restore();
        }
      }]
    });

const backdrop = document.getElementById('utilisation-modal-backdrop');
  backdrop.style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function closeUtilisationModal() {
  document.getElementById('utilisation-modal-backdrop').style.display = 'none';
  document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    closeOverdueModal();
    closeUtilisationModal();
  }
});

let deadlineChartInstance = null;
let currentDeadlineScreen = 'daily';

function getMidnight(offsetDays = 0) {
  const d = new Date();
  d.setHours(0, 0, 0, 0);
  d.setDate(d.getDate() + offsetDays);
  return d;
}

function parseDueDate(raw) {
  const str = raw.replace('T', ' ').split(' ')[0];
  const [y, m, d] = str.split('-').map(Number);
  const date = new Date(y, m - 1, d, 12);
  date.setHours(0, 0, 0, 0);
  return date;
}

function getRiskColour(count) {
  if (count === 0) return { bg: 'rgba(90,96,112,0.5)',   hover: '#5a6070' };
  if (count === 1) return { bg: 'rgba(79,142,247,0.85)', hover: '#4f8ef7' };
  if (count === 2) return { bg: 'rgba(255,193,7,0.85)',  hover: '#ffc107' };
  return              { bg: 'rgba(255,49,49,0.85)',   hover: '#ff3131' };
}

function buildDeadlineData(tasks, mode) {
  const today = getMidnight();
  const buckets = [];

  if (mode === 'daily') {

    for (let i = 0; i < 5; i++) {
      const start = getMidnight(i);
      const end   = getMidnight(i + 1);
      const label = i === 0
        ? 'Today'
        : i === 1
        ? 'Tomorrow'
        : start.toLocaleDateString('en-GB', { weekday: 'short', day: 'numeric', month: 'short' });

      const matched = tasks.filter(t => {
        if (t.status === 'Completed') return false;
        const due = parseDueDate(t.due_date);
        return due >= start && due < end;
      });

      buckets.push({ label, tasks: matched, start, end });
    }

  } else if (mode === 'weekly') {

    const dayOfWeek = today.getDay();
    const diffToMonday = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
    const thisMonday = getMidnight(diffToMonday);

    for (let i = 0; i < 4; i++) {
      const start = new Date(thisMonday);
      start.setDate(thisMonday.getDate() + i * 7);
      const end = new Date(start);
      end.setDate(start.getDate() + 7);

      const fmt = d => d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
      const label = i === 0 ? `This week` : `${fmt(start)}`;

      const matched = tasks.filter(t => {
        if (t.status === 'Completed') return false;
        const due = parseDueDate(t.due_date);
        return due >= start && due < end;
      });

      buckets.push({ label, tasks: matched, start, end });
    }

  } else {

    const now = new Date();
    for (let i = 0; i < 3; i++) {
      const start = new Date(now.getFullYear(), now.getMonth() + i, 1);
      const end   = new Date(now.getFullYear(), now.getMonth() + i + 1, 1);
      const label = start.toLocaleDateString('en-GB', { month: 'long', year: 'numeric' });

      const matched = tasks.filter(t => {
        if (t.status === 'Completed') return false;
        const due = parseDueDate(t.due_date);
        return due >= start && due < end;
      });

      buckets.push({ label, tasks: matched, start, end });
    }
  }

  return buckets;
}

function renderDeadlineChart(buckets) {
  if (deadlineChartInstance) {
    deadlineChartInstance.destroy();
    deadlineChartInstance = null;
  }

  const labels = buckets.map(b => b.label);
  const counts = buckets.map(b => b.tasks.length);
  const colours = counts.map(c => getRiskColour(c));

  const t = getChartThemeColors();

  const canvas = document.getElementById('deadline-chart');
  const ctx = canvas.getContext('2d');

  deadlineChartInstance = new Chart(ctx, {
    type: 'bar',
    data: { labels, datasets: [{
      data: counts,
      backgroundColor: colours.map(c => c.bg),
      hoverBackgroundColor: colours.map(c => c.hover),
      borderRadius: 10, borderSkipped: false, barPercentage: 0.6, categoryPercentage: 0.65,
    }]},
    options: {
      responsive: true, maintainAspectRatio: false,
      animation: { duration: 500, easing: 'easeOutQuart' },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1C2131', borderColor: '#3a3f4b', borderWidth: 1,
          titleColor: '#e8ecf5', bodyColor: '#a0aabf',
          titleFont: { family: 'Lexend Deca', weight: '600', size: 14 },
          bodyFont: { family: 'Lexend Deca', size: 14 }, padding: 16,
          callbacks: {
            title: items => labels[items[0].dataIndex],
            label: context => {
              const count = context.parsed.y;
              const risk = count >= 3 ? 'High risk' : count === 2 ? 'Medium risk' : count === 1 ? 'Low risk' : 'No tasks due';
              return [` ${count} task${count !== 1 ? 's' : ''} due`, ` ${risk}`];
            }
          }
        }
      },
      scales: {
        x: {
          grid: { display: false },
          border: { display: false },
          title: {
            display: true,
            text: 'Period',
            color: t.title,
            font: { family: 'Lexend Deca', size: 18, weight: '600' },
            padding: { top: 8 }
          },
          ticks: { color: t.ticks, font: { family: 'Lexend Deca', size: 14 }, maxRotation: 20 }
        },
        y: {
          beginAtZero: true,
          grid: { color: t.grid },
          border: { display: false },
          title: {
            display: true,
            text: 'Tasks Due',
            color: t.title,
            font: { family: 'Lexend Deca', size: 18, weight: '600' },
            padding: { bottom: 8 }
          },
          ticks: {
            color: t.ticks,
            font: { family: 'Lexend Deca', size: 13 },
            stepSize: 1,
            callback: v => Number.isInteger(v) ? `${v}` : ''
          }
        }
      }
    }
  });
}

function switchDeadlineScreen(mode) {
  currentDeadlineScreen = mode;

  const isDark = document.body.classList.contains('dark-mode');

  const activebg      = isDark ? '#d2d2d2' : '#aaaaaa';
  const activeBorder  = isDark ? '#d2d2d2' : '#9b9b9b';
  const activeText    = isDark ? '#000000'  : '#000000';

  document.querySelectorAll('.deadline-pill').forEach(btn => {
    const isActive = btn.textContent.trim().toLowerCase() === mode;
    btn.classList.toggle('active', isActive);
  });

  if (!cachedTasks) return;

  const buckets = buildDeadlineData(cachedTasks, mode);
  const subtitle = document.getElementById('deadline-subtitle');
  const totalDue = buckets.reduce((sum, b) => sum + b.tasks.length, 0);

  const periodLabel = mode === 'daily' ? 'next 5 days' : mode === 'weekly' ? 'next 4 weeks' : 'next 3 months';
  subtitle.textContent = `${totalDue} task${totalDue !== 1 ? 's' : ''} due in the ${periodLabel}`;

  renderDeadlineChart(buckets);
}

async function openDeadlineModal() {
  if (!cachedTasks) {
    cachedTasks = await getAllTasksByEmployee(tempEmployeeId);
  }


  currentDeadlineScreen = 'daily';
  switchDeadlineScreen('daily');

  document.getElementById('deadline-modal-backdrop').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function closeDeadlineModal() {
  document.getElementById('deadline-modal-backdrop').style.display = 'none';
  document.body.style.overflow = '';
}


document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    closeOverdueModal();
    closeUtilisationModal();
    closeDeadlineModal();
  }
});

const stageOrder = { 'Not Started': 0, 'In Progress': 1, 'Awaiting Validation': 2, 'Completed': 3 };
let currentSort = null;

function toggleFilterMenu() {
  const menu = document.getElementById('filter-menu');
  const isOpen = menu.style.display === 'block';
  menu.style.display = isOpen ? 'none' : 'block';


  if (!isOpen) {
    setTimeout(() => {
      document.addEventListener('click', closeFilterMenuOnOutsideClick);
    }, 0);
  }
}

function closeFilterMenuOnOutsideClick(e) {
  const menu = document.getElementById('filter-menu');
  const btn  = document.getElementById('filter-btn');
  if (!menu.contains(e.target) && !btn.contains(e.target)) {
    menu.style.display = 'none';
    document.removeEventListener('click', closeFilterMenuOnOutsideClick);
  }
}

function applySort(mode) {
  currentSort = mode;


  document.querySelectorAll('.filter-option').forEach(btn => {
    btn.classList.remove('active');
    if (btn.getAttribute('onclick') === `applySort('${mode}')`) {
      btn.classList.add('active');
    }
  });

  const labels = {
    due_asc:       'Due ↑',
    due_desc:      'Due ↓',
    progress_asc:  'Progress ↑',
    progress_desc: 'Progress ↓',
  };
  document.getElementById('filter-btn').textContent = labels[mode];


  document.getElementById('filter-menu').style.display = 'none';
  document.removeEventListener('click', closeFilterMenuOnOutsideClick);


  const query = document.getElementById('task-search').value;
  filterTasks(query);
}

function getSortedTasks(tasks) {
  if (!currentSort) return tasks;

  return [...tasks].sort((a, b) => {
    if (currentSort === 'due_asc' || currentSort === 'due_desc') {
      const da = new Date(a.due_date.replace('T', ' ').split(' ')[0] + 'T12:00:00');
      const db = new Date(b.due_date.replace('T', ' ').split(' ')[0] + 'T12:00:00');
      return currentSort === 'due_asc' ? da - db : db - da;
    }

    if (currentSort === 'progress_asc' || currentSort === 'progress_desc') {
      const pa = stageOrder[a.status] ?? 0;
      const pb = stageOrder[b.status] ?? 0;
      return currentSort === 'progress_asc' ? pa - pb : pb - pa;
    }

    return 0;
  });
}

const effortLabels = { 'XS': 'Extra Small', 'S': 'Small', 'M': 'Medium', 'L': 'Large', 'XL': 'Extra Large' };

const priorityBadgeStyle = {
  'High':   { bg: 'rgba(255,49,49,0.15)',   color: '#ff3131' },
  'Medium': { bg: 'rgba(255,193,7,0.15)',   color: '#ffc107' },
  'Low':    { bg: 'rgba(40,167,69,0.15)',   color: '#28a745' },
};

const statusBadgeStyle = {
  'Not Started':         { bg: 'rgba(255,49,49,0.15)',   color: '#ff3131' },
  'In Progress':         { bg: 'rgba(255,193,7,0.15)',   color: '#ffc107' },
  'Awaiting Validation': { bg: 'rgba(79,142,247,0.15)',  color: '#4f8ef7' },
  'Completed':           { bg: 'rgba(40,167,69,0.15)',   color: '#28a745' },
};

function formatDisplayDate(raw) {
  if (!raw) return '—';
  const str = raw.replace('T', ' ').split(' ')[0];
  const [y, m, d] = str.split('-').map(Number);
  return new Date(y, m - 1, d, 12).toLocaleDateString('en-GB', {
    day: 'numeric', month: 'short', year: 'numeric'
  });
}

  function openTaskDetailModal(task) {
    document.getElementById('td-title').textContent   = task.title || '—';
    document.getElementById('td-project').textContent = task.project_name ? `Project: ${task.project_name}` : 'No project assigned';

    const sb = statusBadgeStyle[task.status] ?? { bg:'rgba(255,255,255,0.08)', color:'#a0aabf' };
    const statusEl = document.getElementById('td-status-badge');
    statusEl.textContent = task.status || '—'; statusEl.style.background = sb.bg; statusEl.style.color = sb.color;

    const pb = priorityBadgeStyle[task.priority] ?? { bg:'rgba(255,255,255,0.08)', color:'#a0aabf' };
    const priorityEl = document.getElementById('td-priority-badge');
    priorityEl.textContent = `${task.priority||'—'} Priority`; priorityEl.style.background = pb.bg; priorityEl.style.color = pb.color;

    document.getElementById('td-effort-badge').textContent = `Effort: ${task.estimated_effort||'—'}`;
    document.getElementById('td-description').textContent = task.description || 'No description provided.';
    document.getElementById('td-assigner').textContent = task.assigner_name || '—';
    document.getElementById('td-created').textContent = formatDisplayDate(task.created_date);
    document.getElementById('td-due').textContent = formatDisplayDate(task.due_date);
    document.getElementById('td-effort-label').textContent = effortLabels[task.estimated_effort] ?? task.estimated_effort ?? '—';

    for (let s=1; s<=4; s++) document.getElementById(`td-stage-${s}`).style.backgroundColor = getStageColour(task.status, s);

    document.getElementById('task-detail-backdrop').style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }

  function closeTaskDetailModal() {
    document.getElementById('task-detail-backdrop').style.display = 'none';
    document.body.style.overflow = '';
  }

async function loadTasks() {
  const tasks = await getAllTasksByEmployee(tempEmployeeId);
  cachedTasks = tasks;
  console.log(tasks);
  buildTaskCards(tasks);
  }

  loadTasks();

</script>

</html>