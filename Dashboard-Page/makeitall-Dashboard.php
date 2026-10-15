<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
    require "../navbar/navbar.php";
?>

<!-- ============================================================
     HEAD: Page metadata and external dependencies
     ============================================================ -->
<head>
  <title>Make-It-All - Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
  <link href="dash.css" rel=stylesheet>
</head>



<script>
  async function getEmployeeName(employeeId) {
    const response = await fetch(`<?= BASE_URL ?>api/get_employee_by_id.php?employee_id=${employeeId}`);
    const data = await response.json();

    if (!data.success) {
      throw new Error(data.error);
    }

    return `${data.data.first_name} ${data.data.last_name}`;
  }
</script>

<!-- ============================================================
     BODY: Page layout and UI components
     ============================================================ -->
<body class="dark-mode">

  <!-- Welcome Banner -->
  <div class="container-fluid d-flex align-items-center justify-content-between" style="width: 97%; background-color: transparent; padding-top: 20px; padding-bottom: 20px;">
    <h1 class="m-0">Welcome, <span id="employee-name">...</span></h1>
    <div style="position: relative; display: inline-block;">
      <button id="alerts-btn" class="pill-btn" style="width: 400px; padding: 10px 32px; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 10px;"
  onclick="loadAlerts()">
  <span id="alerts-badge" style="width: 20px; height: 20px; background: #ff3131; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: #ffffff; flex-shrink: 0;">!</span>
  Alerts
</button>
    </div>
  </div>

  <script>
    getEmployeeName(employeeId)
      .then(name => document.getElementById("employee-name").textContent = name);
  </script>

  <!-- ============================================================
       SECTION: Projects and Charts (top two-column grid)
       ============================================================ -->
  <div
    class="container-fluid bg-transparent"
    style="width: 97%; min-height: 400px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding: 0;">

<!-- Projects Panel -->
<div class="container rounded-5 d-flex flex-column py-3 px-4" style="min-height: 400px">

  <!-- Projects Header: title, search, and sort controls -->
  <div class="projects-header d-flex justify-content-between align-items-start">
    <h1 class="m-0" style="font-size: 2rem">Projects</h1>

    <div class="d-flex gap-2">

      <!-- Project Search Input -->
      <div style="position: relative;">
        <input
          id="project-search"
          class="search-input"
          type="text"
          placeholder="Search projects..."
          oninput="filterProjects(this.value)"
          style="border-radius: 20px; font-family: 'Lexend Deca', sans-serif; font-size: 0.82rem; padding: 6px 14px 6px 32px; outline: none; width: 200px; transition: border-color 0.15s;"
          onfocus="this.style.borderColor='#eea934'"
          onblur="this.style.borderColor=''"
        />
        <svg class="search-icon" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); opacity:0.4;" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </div>

      <!-- Project Sort Dropdown -->
      <div style="position: relative;">
        <button id="project-filter-btn" class="sort-btn" onclick="toggleProjectFilterMenu()" style="border-radius:20px; font-family:'Lexend Deca',sans-serif; font-size:0.82rem; padding:6px 14px; cursor:pointer; transition:border-color 0.15s; white-space:nowrap;">
          Sort ↕
        </button>

        <div id="project-filter-menu" class="filter-menu" style="display:none; position:absolute; top:calc(100% + 6px); right:0; border-radius:10px; overflow:hidden; z-index:100; min-width:220px;">
          <div style="padding: 6px 0;">
            <div class="filter-menu-label" style="padding: 6px 10px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">Due Date</div>
            <button class="project-filter-option filter-menu-option" onclick="applyProjectSort('due_asc')"  style="display:block; width:100%; text-align:left; border:none; font-family:'Lexend Deca',sans-serif; font-size:0.82rem; padding:7px 14px; cursor:pointer;">↑ Earliest first</button>
            <button class="project-filter-option filter-menu-option" onclick="applyProjectSort('due_desc')" style="display:block; width:100%; text-align:left; border:none; font-family:'Lexend Deca',sans-serif; font-size:0.82rem; padding:7px 14px; cursor:pointer;">↓ Latest first</button>

            <div class="filter-menu-divider" style="height:1px; margin:4px 0;"></div>

            <div class="filter-menu-label" style="padding: 6px 10px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">Progress</div>
            <button class="project-filter-option filter-menu-option" onclick="applyProjectSort('progress_asc')"  style="display:block; width:100%; text-align:left; border:none; font-family:'Lexend Deca',sans-serif; font-size:0.82rem; padding:7px 14px; cursor:pointer;">↑ Least complete first</button>
            <button class="project-filter-option filter-menu-option" onclick="applyProjectSort('progress_desc')" style="display:block; width:100%; text-align:left; border:none; font-family:'Lexend Deca',sans-serif; font-size:0.82rem; padding:7px 14px; cursor:pointer;">↓ Most complete first</button>
          </div>
        </div>
      </div>
        <div class="d-flex justify-content-end">
          <a href="<?= BASE_URL ?>Project-Comparison-Page/makeitall-Project-Comparison.php?employee_id=<?= urlencode($employeeId) ?>"
            class="action-link"
            style="border-radius: 20px; font-family: 'Lexend Deca', sans-serif; font-size: 0.82rem; padding: 6px; text-decoration: none;">
            Compare Projects
          </a>


          <?php if (($_SESSION['role_type'] ?? '') === 'manager'): ?>
          <button
            id="project-scope-toggle"
            class="sort-btn"
            onclick="toggleProjectScope()"
            style="border-radius:20px; font-family:'Lexend Deca',sans-serif; font-size:0.82rem; padding:6px 14px; cursor:pointer; white-space:nowrap;">
            All Projects
          </button>
          <?php endif; ?>

    </div>
  </div>

  </div>

      <!-- Project Cards List -->
      <div class="mt-1" id="project-cards-container" style="height: 630px; overflow-y: auto; padding: 4px; "></div>

    </div>

  <!-- Charts Panel -->
<div class="container rounded-5 py-3 px-4" style="min-height: 400px;">



  <!-- Slide 0: Project Progress Bar Chart -->
  <div id="chart-slide-0">

    <div class="d-flex align-items-center gap-2">
      <h1 class="m-0" id="selected-project-title" style="font-size: 2rem">Project Progress</h1>
      <div class="graph-info-wrapper">
        <span class="graph-info-icon" tabindex="0" aria-label="About this chart">&#9432;</span>
        <div class="graph-info-popup" id="manager-chart-info-popup">
          <strong class="popup-title">Project Progress</strong>
          <p class="popup-body">Displays completed vs remaining tasks for each project as a stacked bar chart. Green bars show completed tasks, red bars show what is still outstanding.</p>
        </div>
      </div>
    </div>





    <div class="inner-container container mt-3" style="border-radius: 24px; padding: 10px 10px; height: 580px; display: flex; flex-direction: column; justify-content: center;">
      
    <div style="position: relative; height: 520px; margin-top: 16px; display: flex; align-items: center; justify-content: center;">
        <canvas id="project-progress-chart"></canvas>
    </div>
    </div>
  </div>

  <!-- Slide 1: Effort Estimation Accuracy Bar Chart -->
  <div id="chart-slide-1" style="display: none;">
    <div class="d-flex align-items-center gap-2">
      <h1 class="m-0" style="font-size: 2rem">Effort Estimation Accuracy</h1>
      <div class="graph-info-wrapper">
        <span class="graph-info-icon" tabindex="0" aria-label="About this chart">&#9432;</span>
        <div class="graph-info-popup" id="effort-chart-info-popup">
          <strong class="popup-title">Effort Estimation Accuracy</strong>
          <p class="popup-body">Compares the estimated effort assigned to tasks against the actual effort recorded on completion. Highlights where estimations are consistently over or under for a given project.</p>
        </div>
      </div>
    </div>
    <div class="inner-container mt-3" style="border-radius: 24px; padding: 12px 4px 20px 16px; height: 580px; display: flex; flex-direction: column;">
      <p class="subtitleEA" id="effort-accuracy-subtitle" style="align-self: flex-start; margin-bottom: 8px;"></p>
      <div style="position: relative; flex: 1;">
        <canvas id="effort-accuracy-chart"></canvas>
      </div>
    </div>
  </div>

<!-- Carousel Nav -->
<div class="d-flex gap-2 mb-2 mt-3 justify-content-center align-items-center">
  <button id="chart-pill-0" class="pill-btn active" onclick="goToChart(0)">Project Progress</button>
  <button id="chart-pill-1" class="pill-btn" onclick="goToChart(1)">Effort Accuracy</button>

</div>


 <!-- Carousel Viewport -->
<div style="position: relative;">
</div>
</div>
</div>

  <!-- ============================================================
       SECTION: Team Workload
       ============================================================ -->
  <div id="team-workload-container" class="container-fluid mt-4 rounded-5 py-3 px-4" style="min-height: 400px; width: 97%">

    <!-- Team Workload Header: title, search, and filter controls -->
    <div class="projects-header d-flex justify-content-between align-items-start">
      <h1 class="m-0 mb-3">Team Workload</h1>

      <div class="d-flex gap-2">

    <!-- Employee Search Input -->
    <div style="position: relative;">
      <input
        id="employee-search"
        class="search-input"
        type="text"
        placeholder="Search employees..."
        oninput="applyEmployeeFilters()"
        style="border-radius: 20px; font-family: 'Lexend Deca', sans-serif; font-size: 0.82rem; padding: 6px 14px 6px 32px; outline: none; width: 200px; transition: border-color 0.15s;"
        onfocus="this.style.borderColor='#eea934'"
        onblur="this.style.borderColor=''"
      />
      <svg class="search-icon" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); opacity:0.4;" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
      </svg>
    </div>

    <!-- Employee Filter Dropdown -->
    <div style="position: relative;">
      <button id="employee-filter-btn" class="sort-btn" onclick="toggleEmployeeFilterMenu()" style="border-radius: 20px; font-family: 'Lexend Deca', sans-serif; font-size: 0.82rem; padding: 6px 14px; cursor: pointer; transition: border-color 0.15s; white-space: nowrap;">Filters ↕</button>

      <div id="employee-filter-menu" class="filter-menu" style="display: none; position: absolute; top: calc(100% + 6px); right: 0; border-radius: 10px; overflow: hidden; z-index: 100; min-width: 200px;">
        <div style="padding: 6px 0;">

          <div style="padding: 6px 10px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">Task Progress</div>
          <button class="filter-menu-option" onclick="applyEmployeeSort('progress_desc')">↓ Most progress first</button>
          <button class="filter-menu-option" onclick="applyEmployeeSort('progress_asc')">↑ Least progress first</button>

          <div style="height: 1px; background: #2a2f3b; margin: 4px 0;"></div>

          <div style="padding: 6px 10px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">Active Tasks</div>
          <button class="filter-menu-option" onclick="applyEmployeeSort('active_desc')">↓ Most active first</button>
          <button class="filter-menu-option" onclick="applyEmployeeSort('active_asc')">↑ Least active first</button>

          <div style="height: 1px; background: #2a2f3b; margin: 4px 0;"></div>

          <div style="padding: 6px 10px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">Completed Tasks</div>
          <button class="filter-menu-option" onclick="applyEmployeeSort('completed_desc')">↓ Most completed first</button>
          <button class="filter-menu-option" onclick="applyEmployeeSort('completed_asc')">↑ Least completed first</button>

          <div style="height: 1px; background: #2a2f3b; margin: 4px 0;"></div>

          <div style="padding: 6px 10px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">Estimated Effort</div>
          <button class="filter-menu-option" onclick="applyEmployeeSort('effort_desc')">↓ Most effort first</button>
          <button class="filter-menu-option" onclick="applyEmployeeSort('effort_asc')">↑ Least effort first</button>

          <div style="height: 1px; background: #2a2f3b; margin: 4px 0;"></div>

          <div style="padding: 6px 10px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">Total Tasks</div>
          <button class="filter-menu-option" onclick="applyEmployeeSort('total_desc')">↓ Most tasks first</button>
          <button class="filter-menu-option" onclick="applyEmployeeSort('total_asc')">↑ Least tasks first</button>

        </div>
      </div>
    </div>

    <!-- Compare Employees Button -->
    <a href="<?= BASE_URL ?>Employee-Comparisons-Page/makeitall-Employee-Comparison.php?employee_id=<?= urlencode($employeeId) ?>"
      class="action-link"
      style="border-radius: 20px; font-family: 'Lexend Deca', sans-serif; font-size: 0.82rem; padding: 6px; text-decoration: none;">
      Compare Employees
    </a>

  </div>
</div>

    <!-- Employee Cards Grid -->
    <div id="employee-cards-container" class="d-flex flex-wrap gap-5 mt-1"></div>

  </div>


<!-- Alerts Modal -->
<div id="alerts-modal-overlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); z-index: 9999; align-items: flex-start; justify-content: center; padding-top: 80px; overflow-y: auto; overscroll-behavior: contain;">
  <div class="alerts-modal-box" style="border-radius: 20px; padding: 32px; min-width: 520px; max-width: 780px; width: 90%; position: relative; margin-bottom: 32px;">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="m-0 alerts-modal-title" style="font-size: 1.6rem;">Alerts</h2>
      <button class="alerts-close-btn" onclick="closeAlertsModal()" style="background: none; border: none; font-size: 1.4rem; cursor: pointer; line-height: 1;">✕</button>
    </div>

    <!-- Alerts content -->
    <div id="alerts-list">
      <p class="alerts-muted-text" style="font-size: 0.9rem; text-align: center; margin-top: 16px;">Loading alerts...</p>
    </div>

  </div>
</div>

<script>
  document.getElementById('alerts-modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
  });

  const ALERT_CAPACITY_PTS = 6;
  const ALERT_EFFORT_POINTS = { XS: 1, S: 4, M: 8, L: 24, XL: 40 };

  let _scrollY = 0;

  function getAlertWeekKey(dateStr) {
    const d = new Date(dateStr);
    const day = d.getDay();
    const diffToMonday = (day === 0 ? -6 : 1 - day);
    const monday = new Date(d);
    monday.setDate(d.getDate() + diffToMonday);
    return monday.toISOString().split('T')[0];
  }

  function getMostRecentWeekKey(weekMap) {
    return [...weekMap.keys()].sort().at(-1);
  }

  function getAlertCardBg() {
    return document.body.classList.contains('dark-mode') ? '#151925' : '#f8f9fa';
  }

  function getAlertCardHoverBg() {
    return document.body.classList.contains('dark-mode') ? '#1e2438' : '#e9ecef';
  }

  function getAlertTextColour() {
    return document.body.classList.contains('dark-mode') ? '#ffffff' : '#111111';
  }

  function getAlertMutedColour() {
    return document.body.classList.contains('dark-mode') ? '#a0aabf' : '#555555';
  }

function closeAlertsModal() {
  document.getElementById('alerts-modal-overlay').style.display = 'none';

  document.body.style.position = '';
  document.body.style.top = '';
  document.body.style.width = '';
  window.scrollTo(0, _scrollY);
}


  async function loadAlerts() {

    _scrollY = window.scrollY;
    document.body.style.position = 'fixed';
    document.body.style.top = `-${_scrollY}px`;
    document.body.style.width = '100%';

    const overlay = document.getElementById('alerts-modal-overlay');
    overlay.style.display = 'flex';

    const alertsList = document.getElementById('alerts-list');
    alertsList.innerHTML = `<p class="alerts-muted-text" style="font-size: 0.9rem; text-align: center; margin-top: 16px;">Loading alerts...</p>`;

    try {
      const projects = await getEmployeeProjects(employeeId);
      const now = new Date();
      let html = '';

      const cardBg      = getAlertCardBg();
      const cardHoverBg = getAlertCardHoverBg();
      const textColour  = getAlertTextColour();
      const mutedColour = getAlertMutedColour();

      // -------------------------------------------------------
      // SECTION 1: Project Status Alerts
      // -------------------------------------------------------
      const atRiskProjects = projects.filter(p => p.status === 'At Risk' || p.status === 'Behind Schedule');

      if (atRiskProjects.length > 0) {
        html += `<p class="alerts-section-label" style="font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 10px;">Project Alerts</p>`;

        atRiskProjects.forEach(project => {
          const isBehind  = project.status === 'Behind Schedule';
          const colour    = isBehind ? '#ff3131' : '#eea934';
          const projectId = project.project_id || project.id;
          const dueDate   = project.due_date ? project.due_date : 'N/A';

html += `
  <a href="<?= BASE_URL ?>Specific-Project-Analysis-Page/makeitall-Project-Page.php?id=${encodeURIComponent(projectId)}"
     style="display: block; text-decoration: none; background: ${cardBg}; border: 1px solid ${colour}33; border-radius: 12px; padding: 20px 20px; margin-bottom: 10px; transition: background 0.15s;"
     onmouseover="this.style.background='${cardHoverBg}'"
     onmouseout="this.style.background='${cardBg}'">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <div>
        <p style="margin: 0; color: ${textColour}; font-size: 1.05rem; font-weight: 600;">${project.name}</p>
        <p style="margin: 6px 0 0; color: ${mutedColour}; font-size: 0.88rem;">Status: <span style="color: ${colour}; font-weight: 600;">${project.status}</span> · Due: ${dueDate}</p>
      </div>
      <span style="color: ${mutedColour}; font-size: 1rem;">›</span>
    </div>
  </a>
`;
      });
    }


    // -------------------------------------------------------
    // SECTION 2: Overdue Task Alerts
    // -------------------------------------------------------
    const taskFetches = await Promise.all(
      projects.map(async project => {
        const projectId = project.project_id || project.id;
        try {
          const data = await getTasksByProject(projectId);
          const overdueTasks = data.filter(task =>
            task.due_date && task.status !== 'Completed' && new Date(task.due_date) < now
          );
          return { project, projectId, overdueTasks };
        } catch {
          return { project, projectId, overdueTasks: [] };
        }
      })
    );


    const projectsWithOverdue = taskFetches.filter(r => r.overdueTasks.length > 0);


    if (projectsWithOverdue.length > 0) {
      html += `<p class="alerts-section-label" style="font-size: 1.15rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin: 16px 0 10px;">Overdue Tasks</p>`;


      projectsWithOverdue.forEach(({ project, projectId, overdueTasks }) => {
        const count = overdueTasks.length;
        const mostOverdue = overdueTasks.reduce((oldest, t) =>
          new Date(t.due_date) < new Date(oldest.due_date) ? t : oldest
        );
        const daysOverdue = Math.floor((now - new Date(mostOverdue.due_date)) / (1000 * 60 * 60 * 24));


        html += `
          <a href="<?= BASE_URL ?>Specific-Project-Analysis-Page/makeitall-Project-Page.php?id=${encodeURIComponent(projectId)}"
             style="display: block; text-decoration: none; background: ${cardBg}; border: 1px solid #ff313333; border-radius: 12px; padding: 20px 20px; margin-bottom: 10px; transition: background 0.15s;"
             onmouseover="this.style.background='${cardHoverBg}'"
             onmouseout="this.style.background='${cardBg}'">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <div>
                <p style="margin: 0; color: ${textColour}; font-size: 1.05rem; font-weight: 600;">${project.name}</p>
                <p style="margin: 6px 0 0; color: ${mutedColour}; font-size: 0.88rem;">
                  <span style="color: #ff3131; font-weight: 600;">${count} overdue task${count !== 1 ? 's' : ''}</span>
                  · oldest is <span style="color: #ff3131; font-weight: 600;">${daysOverdue} day${daysOverdue !== 1 ? 's' : ''}</span> overdue
                </p>
              </div>
              <span style="color: ${mutedColour}; font-size: 1rem;">›</span>
            </div>
          </a>
        `;
      });
      }

      // -------------------------------------------------------
      // SECTION 3: Employee Utilisation Alerts
      // -------------------------------------------------------
      const employeeMap = new Map();
      await Promise.all(
        projects.map(async project => {
          const projectId = project.project_id || project.id;
          try {
            const employees = await getAllEmployeesByProject(projectId);
            employees.forEach(emp => {
              if (!employeeMap.has(emp.employee_id)) employeeMap.set(emp.employee_id, emp);
            });
          } catch { /* skip */ }
        })
      );

      const utilisationAlerts = [];
      await Promise.all(
        [...employeeMap.values()].map(async emp => {
          try {
            const tasks = await getAllTasksByEmployee(emp.employee_id);
            const weekMap = new Map();
            tasks.forEach(task => {
              if (!task.due_date || task.task_type === 'private') return;
              const dateStr = task.due_date.replace('T', ' ').split(' ')[0];
              const weekKey = getAlertWeekKey(dateStr);
              const pts = ALERT_EFFORT_POINTS[task.estimated_effort] ? ALERT_EFFORT_POINTS[task.estimated_effort] : 0;
              weekMap.set(weekKey, (weekMap.get(weekKey) ? weekMap.get(weekKey) : 0) + pts);
            });

            if (weekMap.size === 0) return;

            const latestWeek     = getMostRecentWeekKey(weekMap);
            const latestPts      = weekMap.get(latestWeek);
            const utilisationPct = Math.round((latestPts / ALERT_CAPACITY_PTS) * 100);

            if (utilisationPct > 100 || utilisationPct < 50) {
              utilisationAlerts.push({ emp, utilisationPct, latestPts, weekStart: latestWeek, isOver: utilisationPct > 100 });
            }
          } catch {}
        })
      );

      if (utilisationAlerts.length > 0) {
        html += `<p class="alerts-section-label" style="font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin: 16px 0 10px;">Employee Utilisation</p>`;

        utilisationAlerts.sort((a, b) => b.utilisationPct - a.utilisationPct);

        let utilisationCardsHtml = '';
        utilisationAlerts.forEach(({ emp, utilisationPct, latestPts, weekStart, isOver }) => {
          const colour    = isOver ? '#ff3131' : '#4f8ef7';
          const label     = isOver ? 'Over-utilised' : 'Under-utilised';
          const weekDate  = new Date(weekStart);
          const weekEnd   = new Date(weekDate);
          weekEnd.setDate(weekDate.getDate() + 6);
          const fmt       = d => d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
          const weekLabel = `${fmt(weekDate)} – ${fmt(weekEnd)}`;
          const empName   = emp.full_name ? emp.full_name : emp.first_name + ' ' + emp.last_name;

          utilisationCardsHtml += `
            <a href="<?= BASE_URL ?>Employee-Analytics-Page/makeitall-Employee-Overview.php?employee_id=${encodeURIComponent(emp.employee_id)}"
              style="display: block; text-decoration: none; background: ${cardBg}; border: 1px solid ${colour}33; border-radius: 12px; padding: 20px 20px; margin-bottom: 10px; transition: background 0.15s;"
              onmouseover="this.style.background='${cardHoverBg}'"
              onmouseout="this.style.background='${cardBg}'">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                  <p style="margin: 0; color: ${textColour}; font-size: 1.05rem; font-weight: 600;">${empName}</p>
                  <p style="margin: 6px 0 0; color: ${mutedColour}; font-size: 0.88rem;">
                    <span style="color: ${colour}; font-weight: 600;">${label} at ${utilisationPct}%</span>
                    · ${latestPts} / ${ALERT_CAPACITY_PTS} pts
                  </p>
                </div>
                <span style="color: ${mutedColour}; font-size: 1rem;">›</span>
              </div>
            </a>
          `;
          });
        const scrollbarColour = document.body.classList.contains('dark-mode') ? '#3a3f4b #1C2131' : '#ced4da #ffffff';
        html += `
          <div style="max-height: 260px; overflow-y: auto; padding-right: 4px; scrollbar-width: thin; scrollbar-color: ${scrollbarColour};">
            ${utilisationCardsHtml}
          </div>
        `;
      }

      if (html === '') {
        html = `<p class="alerts-muted-text" style="font-size: 0.9rem; text-align: center; margin-top: 16px;">No alerts at this time. ✅</p>`;
      }

      alertsList.innerHTML = html;

    } catch (err) {
      console.error('Failed to load alerts:', err);
      alertsList.innerHTML = `<p style="color: #ff3131; font-size: 0.85rem; text-align: center;">Failed to load alerts.</p>`;
    }
  }
</script>

<div style="height: 2rem;"></div>

</body>

<script>

// ============================================================
// CONFIG: Page-level constants
// ============================================================

const projectId  = 1;


// ============================================================
// API: Data fetching functions
// ============================================================

async function getEmployeeProjects(employeeId) {
  const response = await fetch(`<?= BASE_URL ?>api/get_employee_projects.php?employee_id=${employeeId}`);
  const result = await response.json();
  if (!result.success) throw new Error(result.error);
  return result.data.projects;
}

async function getTasksByProject(projectId) {
  const response = await fetch(`<?= BASE_URL ?>api/get_all_tasks_by_project.php?project_id=${projectId}`);
  const result = await response.json();
  if (!result.success) throw new Error(result.error);
  return result.data.tasks;
}

async function getAllTasksByEmployee(employeeId) {
  const response = await fetch(`<?= BASE_URL ?>api/get_all_tasks_by_employee.php?employee_id=${employeeId}`);
  const result = await response.json();
  if (!result.success) throw new Error(result.error);
  return result.data.tasks;
}

async function getAllEmployeesByProject(projectId) {
  const response = await fetch(`<?= BASE_URL ?>api/get_all_employees_by_project.php?project_id=${projectId}`);
  const result = await response.json();
  if (!result.success) throw new Error(result.error);
  return result.data.employees;
}

async function getProjectEffortEstimationAccuracy(projectId, employeeId = null) {
  let url = `<?= BASE_URL ?>api/get_project_effort_estimation_accuracy.php?project_id=${projectId}`;
  if (employeeId !== null) url += `&employee_id=${employeeId}`;
  const response = await fetch(url);
  const result = await response.json();
  if (!result.success) throw new Error(result.error);
  return result.data;
}

async function getManagerProjectProgressTrend(filters = {}) {
  const params = new URLSearchParams();

  if (filters.search) params.append('search', filters.search);
  if (filters.teamleader_id !== undefined && filters.teamleader_id !== null) {
    params.append('teamleader_id', String(filters.teamleader_id));
  }
  if (filters.min_progress !== undefined && filters.min_progress !== null) {
    params.append('min_progress', String(filters.min_progress));
  }
  if (filters.max_progress !== undefined && filters.max_progress !== null) {
    params.append('max_progress', String(filters.max_progress));
  }
  params.append('active_only', filters.active_only === false ? '0' : '1');

  const response = await fetch(`<?= BASE_URL ?>api/get_manager_project_progress_trend.php?${params.toString()}`);
  const result = await response.json();
  if (!result.success) throw new Error(result.error);
  return result.data;
}


// ============================================================
// UTILITIES: Shared helper functions
// ============================================================

function getStatusColour(status) {
  switch (status) {
    case "Behind":  return "#ff3131";
    case "On Time": return "#28a745";
    case "At Risk": return "#eea934";
    default:        return "#6c757d";
  }
}

function getProgressBarColour(percentage) {
  if (percentage < 33) return "#ff3131";
  if (percentage < 66) return "#ffc107";
  return "#28a745";
}

async function getProjectCompletionPercentage(projectId) {
  const tasks = await getTasksByProject(projectId);
  const totalTasks = tasks.length;
  const completedTasks = tasks.filter(task => task.status === "Completed").length;
  return totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
}


// ============================================================
// PROJECTS: Card rendering, filtering, and sorting
// ============================================================

let cachedProjects      = [];
let currentProjectSort  = null;
let selectedProjectId   = null;

let showAllProjects = true;

function toggleProjectScope() {
  showAllProjects = !showAllProjects;

  const btn = document.getElementById('project-scope-toggle');
  if (btn) btn.textContent = showAllProjects ? 'All Projects' : 'My Projects';

  applyProjectFilters();

  renderProjectProgressChart(showAllProjects);
}


const USER_ROLE = "<?= htmlspecialchars($_SESSION['role_type']) ?>";

const ALL_PROJECT_IDS = [1,2,3,4,5,6,7,8,9,10];



async function getProjectDetails(projectId) {
  const response = await fetch(`<?= BASE_URL ?>api/get_project_details.php?project_id=${projectId}`);
  const result = await response.json();

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data;
}


async function loadProjects() {
  try {
    let projectsWithProgress;

    if (USER_ROLE === 'manager') {
      const employeeProjects = await getEmployeeProjects(employeeId);
      const employeeProjectIds = employeeProjects.map(p => p.project_id ?? p.id);

      projectsWithProgress = await Promise.all(
        ALL_PROJECT_IDS.map(async (id) => {
          const project = await getProjectDetails(id);
          const percentage = await getProjectCompletionPercentage(id);
          return {
            ...project,
            project_id: project.project_id ?? project.id ?? id,
            completionPercentage: percentage,
            is_member: employeeProjectIds.includes(id),
          };
        })
      );
    } else {

      const projects = await getEmployeeProjects(employeeId);
      projectsWithProgress = await Promise.all(
        projects.map(async (project) => {
          const id = project.project_id || project.id;
          const percentage = await getProjectCompletionPercentage(id);
          return { ...project, project_id: id, completionPercentage: percentage };
        })
      );
    }

    cachedProjects = projectsWithProgress;

    const initialProjects = getSortedProjects(cachedProjects);
    buildProjectCards(initialProjects);

    if (initialProjects.length > 0) {
      selectedProjectId = initialProjects[0].project_id;
      renderEmployeeCards(selectedProjectId);
      highlightSelectedProjectCard(selectedProjectId);
    }
  } catch (error) {
    console.error('Failed to load projects:', error);
  }
}

function buildProjectCards(projects) {
  const container = document.getElementById('project-cards-container');
  container.innerHTML = '';

  if (projects.length === 0) {
    container.innerHTML = `<p style="color:#5a6070; font-size:0.85rem; margin-top:16px;">No projects match your search.</p>`;
    return;
  }

  projects.forEach(project => {
    const percentage = project.completionPercentage ?? 0;
    const progressBarColor = getProgressBarColour(percentage);

    const card = document.createElement('div');
    card.className = 'inner-container container rounded-4 py-3 px-3 mt-3';
    card.style.minHeight = '170px';
    card.style.cursor = 'pointer';
    card.dataset.projectId = String(project.project_id);

    card.addEventListener('click', (event) => {
      selectProject(project, project.project_id, event);
    });

    card.innerHTML = `
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h4 class="m-0">${project.name}</h4>
          <p class="mt-2 mb-0">Due: ${project.due_date}</p>
        </div>
        <div class="d-flex align-items-center gap-2">
        <span class="rounded-pill px-3 py-1 text-white" style="background-color: ${getStatusColour(project.status)}">${project.status}</span>
         <a href="<?= BASE_URL ?>Specific-Project-Analysis-Page/makeitall-Project-Page.php?id=${encodeURIComponent(project.project_id)}"  class="rounded-pill px-3 py-1 text-decoration-none" style="background-color: #aaaaaa; color: #1C2131; font-family: 'Lexend Deca', sans-serif; font-size: 0.85rem; white-space: nowrap;" 
          onclick="event.stopPropagation()">View Project</a>
        </div>
      </div>
      <div class="mt-3">
        <div class="d-flex justify-content-between mb-1">
          <small class=>Progress</small>
          <small class=>${percentage}%</small>
        </div>
        <div class="progress progress-track rounded-4" style="height: 20px;">
          <div class="progress-bar" style="width: ${percentage}%; background-color: ${progressBarColor};" aria-valuenow="${percentage}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    `;

    container.appendChild(card);
  });

  highlightSelectedProjectCard(selectedProjectId);
}

function selectProject(project, projectId, event) {
  selectedProjectId = projectId;
  console.log(selectedProjectId);
  highlightSelectedProjectCard(projectId);
  renderEffortAccuracyChart(projectId);
  renderEmployeeCards(projectId);
}

function highlightSelectedProjectCard(projectId) {
  document.querySelectorAll('#project-cards-container .container').forEach(card => {
    card.style.outline = 'none';
  });

  if (projectId == null) return;

  const selected = document.querySelector(
    `#project-cards-container [data-project-id="${projectId}"]`
  );

  if (selected) {
    const isDark = document.body.classList.contains('dark-mode');
    selected.style.outline = `2px solid ${isDark ? '#ffffff' : '#000000'}`;
  }
}

// Central filter + sort + scope resolver — called by search, sort, and scope toggle
function applyProjectFilters() {
  if (!cachedProjects) return;

  const query = (document.getElementById('project-search')?.value ?? '').trim().toLowerCase();

  // 1. Scope filter: managers can toggle between all vs. their own projects
  let results = (USER_ROLE === 'manager' && !showAllProjects)
    ? cachedProjects.filter(p => p.is_member)   // see note below
    : [...cachedProjects];

  // 2. Search filter
  if (query !== '') {
    results = results.filter(p => (p.name || '').toLowerCase().includes(query));
  }

  console.log(results);

  // 3. Sort
  results = getSortedProjects(results);

  buildProjectCards(results);
}

// Replace old filterProjects — now delegates to the shared resolver
function filterProjects(query) {
  applyProjectFilters();
}

function getSortedProjects(projects) {
  if (!currentProjectSort) return [...projects];

  return [...projects].sort((a, b) => {
    if (currentProjectSort === 'due_asc' || currentProjectSort === 'due_desc') {
      const da = new Date(String(a.due_date).replace('T', ' ').split(' ')[0] + 'T12:00:00');
      const db = new Date(String(b.due_date).replace('T', ' ').split(' ')[0] + 'T12:00:00');
      return currentProjectSort === 'due_asc' ? da - db : db - da;
    }

    if (currentProjectSort === 'progress_asc' || currentProjectSort === 'progress_desc') {
      const pa = a.completionPercentage ?? 0;
      const pb = b.completionPercentage ?? 0;
      return currentProjectSort === 'progress_asc' ? pa - pb : pb - pa;
    }

    return 0;
  });
}

function applyProjectSort(mode) {
  currentProjectSort = mode;

  document.querySelectorAll('.project-filter-option').forEach(btn => {
    btn.classList.remove('active');
    if (btn.getAttribute('onclick') === `applyProjectSort('${mode}')`) {
      btn.classList.add('active');
    }
  });

  applyProjectFilters(); // <-- replaces any direct buildProjectCards() call here


  const labels = {
    due_asc:       'Due ↑',
    due_desc:      'Due ↓',
    progress_asc:  'Progress ↑',
    progress_desc: 'Progress ↓',
  };

  document.getElementById('project-filter-btn').textContent = labels[mode];
  document.getElementById('project-filter-menu').style.display = 'none';
  document.removeEventListener('click', closeProjectFilterMenuOnOutsideClick);

  const query = document.getElementById('project-search').value;
  filterProjects(query);
}

function toggleProjectFilterMenu() {
  const menu = document.getElementById('project-filter-menu');
  const isOpen = menu.style.display === 'block';
  menu.style.display = isOpen ? 'none' : 'block';

  if (!isOpen) {
    setTimeout(() => {
      document.addEventListener('click', closeProjectFilterMenuOnOutsideClick);
    }, 0);
  }
}

function closeProjectFilterMenuOnOutsideClick(e) {
  const menu = document.getElementById('project-filter-menu');
  const btn  = document.getElementById('project-filter-btn');

  if (!menu.contains(e.target) && !btn.contains(e.target)) {
    menu.style.display = 'none';
    document.removeEventListener('click', closeProjectFilterMenuOnOutsideClick);
  }
}


// ============================================================
// CHARTS: Project Progress and Effort Accuracy rendering
// ============================================================

let projectProgressChartInstance = null;

async function renderProjectProgressChart(allProjects) {
  try {
    let chartData, projects;

    if (USER_ROLE === 'manager' && !allProjects) {
      const employeeProjects = await getEmployeeProjects(employeeId);
      const myProjectIds = new Set(employeeProjects.map(p => p.project_id));

      const fullData = await getManagerProjectProgressTrend({ active_only: true });

      projects  = (fullData?.projects   ?? []).filter(p => myProjectIds.has(p.project_id));
      chartData = (fullData?.chart_data ?? []).filter(p => myProjectIds.has(p.project_id));

    } else if (USER_ROLE === 'teamLeader') {
      const employeeProjects = await getEmployeeProjects(employeeId);
      const myProjectIds = new Set(employeeProjects.map(p => p.project_id));

      const fullData = await getManagerProjectProgressTrend({ active_only: true });

      projects  = (fullData?.projects   ?? []).filter(p => myProjectIds.has(p.project_id));
      chartData = (fullData?.chart_data ?? []).filter(p => myProjectIds.has(p.project_id));

    } else {
      const data = await getManagerProjectProgressTrend({ active_only: true });
      chartData  = Array.isArray(data?.chart_data) ? data.chart_data : [];
      projects   = Array.isArray(data?.projects)   ? data.projects   : [];
    }

    console.log("chartData:", chartData);
    console.log("projects:", projects);

    const titleEl = document.getElementById('selected-project-title');
    const canvas  = document.getElementById('project-progress-chart');
    if (!canvas) { console.error('Project progress canvas not found'); return; }

    const ctx = canvas.getContext('2d');

    if (projectProgressChartInstance) {
      projectProgressChartInstance.destroy();
      projectProgressChartInstance = null;
    }

    if (!chartData.length) {
      if (titleEl) { titleEl.textContent = 'Project Progress'; titleEl.style.color = '#a0aabf'; }
      return;
    }

    // Detect current mode
    const isDark       = document.body.classList.contains('dark-mode');
    const tickColor    = isDark ? '#ffffff' : '#333333';
    const gridColor    = isDark ? 'rgba(255,255,255,0.04)' : 'rgba(0,0,0,0.06)';
    const lineColor    = isDark ? 'rgba(255,255,255,0.62)' : 'rgba(0,0,0,0.35)';
    const tooltipBg    = isDark ? '#1C2131' : '#ffffff';
    const tooltipBorder= isDark ? '#3a3f4b' : '#ced4da';
    const tooltipTitle = isDark ? '#e8ecf5' : '#111111';
    const tooltipBody  = isDark ? '#a0aabf' : '#555555';

    const projectMap = {};
    projects.forEach(p => { projectMap[p.project_id] = p; });

    const labels      = chartData.map(d => d.label ? d.label : 'Unnamed Project');
    const values      = chartData.map(d => {
      const num = Number(String(d.value).replace('%', '').trim());
      return Number.isFinite(num) ? num : 0;
    });

    const barColors   = values.map(v => v < 33 ? 'rgba(255, 49, 49, 0.85)'  : v < 66 ? 'rgba(255, 193, 7, 0.85)'  : 'rgba(40, 167, 69, 0.85)');
    const hoverColors = values.map(v => v < 33 ? '#ff3131'                   : v < 66 ? '#ffc107'                   : '#28a745');
    const shortLabels = labels.map(label => label.length > 15 ? label.slice(0, 15) + '…' : label);

    projectProgressChartInstance = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: shortLabels,
        datasets: [{
          data: values,
          backgroundColor: barColors,
          hoverBackgroundColor: hoverColors,
          borderRadius: 8,
          borderSkipped: false,
          barPercentage: 0.5,
          categoryPercentage: 0.6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 700, easing: 'easeOutQuart' },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: tooltipBg,
            borderColor: tooltipBorder,
            borderWidth: 1,
            titleColor: tooltipTitle,
            bodyColor: tooltipBody,
            titleFont: { family: 'Lexend Deca', weight: '600', size: 24 },
            bodyFont:  { family: 'Lexend Deca', size: 24 },
            padding: 24,
            boxPadding: 8,
            displayColors: false,
            callbacks: {
              title: items => labels[items[0].dataIndex],
              label: context => {
                const value     = Number(context.parsed.y || 0);
                const chartItem = chartData[context.dataIndex];
                const project   = projectMap[chartItem.project_id] || {};
                const risk      = value < 33 ? 'Behind' : value < 66 ? 'At Risk' : 'On Track';
                return [
                  ` ${value.toFixed(1)}% complete`,
                  ` ${project.completed_tasks ? project.completed_tasks : '?'} / ${project.total_tasks ? project.total_tasks : '?'} tasks done`,
                  ` ${project.status ? project.status : risk}`,
                  ` Due: ${project.due_date ? project.due_date : 'N/A'}`
                ];
              }
            }
          }
        },
        scales: {
          x: {
            grid:   { display: false },
            border: { display: false },
            title: {
              display: true,
              text: 'Projects',
              color: tickColor,
              font: { family: 'Lexend Deca', size: 18, weight: '600' },
              padding: { top: 8 }
            },
            ticks: { color: tickColor, font: { family: 'Lexend Deca', size: 14 }, maxRotation: 25 }
          },
          y: {
            beginAtZero: true,
            max: 100,
            grid:   { color: gridColor },
            border: { display: false },
            title: {
              display: true,
              text: '% Completion',
              color: tickColor,
              font: { family: 'Lexend Deca', size: 18, weight: '600' },
              padding: { bottom: 8 }
            },
            ticks: { color: tickColor, font: { family: 'Lexend Deca', size: 14 }, callback: value => `${value}%` }
          }
        }
      },
      plugins: [{
        id: 'thresholdLines',
        afterDatasetsDraw(chart) {
          const { ctx, chartArea, scales } = chart;
          [33, 66].forEach(threshold => {
            const y = scales.y.getPixelForValue(threshold);
            ctx.save();
            ctx.beginPath();
            ctx.moveTo(chartArea.left, y);
            ctx.lineTo(chartArea.right, y);
            ctx.strokeStyle = lineColor;
            ctx.lineWidth   = 1;
            ctx.setLineDash([4, 3]);
            ctx.stroke();
            ctx.setLineDash([]);
            ctx.font      = '600 9px Lexend Deca, sans-serif';
            ctx.fillStyle = lineColor;
            ctx.textAlign = 'right';
            ctx.fillText(`${threshold}%`, chartArea.right - 4, y - 4);
            ctx.restore();
          });
        }
      }]
    });

  } catch (error) {
    console.error('Failed to render project progress chart:', error);
  }
}

let effortAccuracyChartInstance = null;

async function renderEffortAccuracyChart(projectId, employeeId = null) {
  try {

    const data = await getProjectEffortEstimationAccuracy(projectId, employeeId);

    const isDark        = document.body.classList.contains('dark-mode');
    const tickColour     = isDark ? '#ffffff' : '#333333';
    const gridColour     = isDark ? 'rgba(255,255,255,0.04)' : 'rgba(0,0,0,0.06)';
    const lineColour     = isDark ? 'rgba(255,255,255,0.6)'  : 'rgba(0,0,0,0.35)';
    const tooltipBg     = isDark ? '#1C2131'   : '#ffffff';
    const tooltipBorder = isDark ? '#3a3f4b'   : '#ced4da';
    const tooltipTitle  = isDark ? '#e8ecf5'   : '#111111';
    const tooltipBody   = isDark ? '#a0aabf'   : '#555555';

    const completedTasks = (data?.tasks ?? []).filter(t =>
      t.status?.trim().toLowerCase() === 'completed' &&
      t.actual_effort_hours    != null &&
      t.estimated_effort_hours != null &&
      t.completed_date         != null &&
      t.completed_date         !== ''
    );

    const subtitle = document.getElementById('effort-accuracy-subtitle');
    const canvas   = document.getElementById('effort-accuracy-chart');
    const ctx      = canvas.getContext('2d');

    if (effortAccuracyChartInstance) {
      effortAccuracyChartInstance.destroy();
      effortAccuracyChartInstance = null;
    }

    if (completedTasks.length === 0) {
      subtitle.textContent = 'No completed tasks with effort data yet.';
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      return;
    }

    completedTasks.sort((a, b) => new Date(a.completed_date) - new Date(b.completed_date));

    // Group tasks by completed date
    const tasksByDay = {};
    completedTasks.forEach(t => {
      const key = new Date(t.completed_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
      if (!tasksByDay[key]) tasksByDay[key] = [];
      tasksByDay[key].push(t);
    });

    const dayKeys  = Object.keys(tasksByDay);
    const dayTasks = Object.values(tasksByDay);

    const labels = dayKeys;

    const ratios = dayTasks.map(group => {
      const avg = group.reduce((sum, t) => sum + (t.actual_effort_hours / t.estimated_effort_hours), 0) / group.length;
      return parseFloat(avg.toFixed(2));
    });

    const barColors   = ratios.map(r => r <= 1 ? 'rgba(40, 167, 69, 0.85)' : r <= 1.5 ? 'rgba(255, 193, 7, 0.85)' : 'rgba(255, 49, 49, 0.85)');
    const hoverColors = ratios.map(r => r <= 1 ? '#28a745'                  : r <= 1.5 ? '#ffc107'                  : '#ff3131');

    const avgRatio = (ratios.reduce((a, b) => a + b, 0) / ratios.length).toFixed(2);
    subtitle.textContent = `Project :  ${data.project_name}`;

    effortAccuracyChartInstance = new Chart(ctx, {
      type: 'bar',
      data: {
        labels,
        datasets: [{
          data: ratios,
          backgroundColor: barColors,
          hoverBackgroundColor: hoverColors,
          borderRadius: 6,
          borderSkipped: false,
          barPercentage: 0.5,
          categoryPercentage: 0.6,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 600, easing: 'easeOutQuart' },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: tooltipBg,
            borderColor: tooltipBorder,
            borderWidth: 1,
            titleColor: tooltipTitle,
            bodyColor: tooltipBody,
            titleFont: { family: 'Lexend Deca', weight: '600', size: 24 },
            bodyFont:  { family: 'Lexend Deca', size: 24 },
            padding: 24,
            boxPadding: 8,
            displayColors: false,
            callbacks: {
              title: items => {
                const group = dayTasks[items[0].dataIndex];
                return group.length > 1
                  ? `${dayKeys[items[0].dataIndex]} · ${group.length} tasks`
                  : (group[0].title.length > 32 ? group[0].title.slice(0, 32) + '…' : group[0].title);
              },
              label: context => {
                const group = dayTasks[context.dataIndex];
                const ratio = context.parsed.y;
                if (group.length === 1) {
                  const t = group[0];
                  return [
                    ` Actual: ${t.actual_effort_hours}h`,
                    ` Estimated: ${t.estimated_effort_hours}h`,
                    ` Ratio: ${ratio}x (${ratio <= 1 ? 'Over' : 'Under'} estimate)`,
                  ];
                }
                const lines = [` Avg ratio: ${ratio}x (${ratio <= 1 ? 'Under' : 'Over'} estimate)`, ''];
                group.forEach(t => {
                  const r    = parseFloat((t.actual_effort_hours / t.estimated_effort_hours).toFixed(2));
                  const name = t.title.length > 24 ? t.title.slice(0, 24) + '…' : t.title;
                  lines.push(` ${name}: ${r}x`);
                });
                return lines;
              }
            }
          }
        },
        scales: {
          x: {
            grid:   { display: false },
            border: { display: false },
            title: {
              display: true,
              text: 'Date',
              color: tickColour,
              font: { family: 'Lexend Deca', size: 18, weight: '600' },
              padding: { top: 8 }
            },
            ticks: { color: tickColour, font: { family: 'Lexend Deca', size: 14 }, maxRotation: 25 }
          },
          y: {
            beginAtZero: true,
            grid:   { color: gridColour },
            border: { display: false },
            title: {
              display: true,
              text: 'Effort Accuracy Ratio',
              color: tickColour,
              font: { family: 'Lexend Deca', size: 18, weight: '600' },
              padding: { bottom: 8 }
            },
            ticks: { color: tickColour, font: { family: 'Lexend Deca', size: 14 }, callback: v => `${v}x` }
          }
        }
      },
      plugins: [{
        id: 'baselineLine',
        afterDatasetsDraw(chart) {
          const { ctx, chartArea, scales } = chart;
          const y1 = scales.y.getPixelForValue(1);
          ctx.save();
          ctx.beginPath();
          ctx.moveTo(chartArea.left, y1);
          ctx.lineTo(chartArea.right, y1);
          ctx.strokeStyle = lineColour;
          ctx.lineWidth   = 1.5;
          ctx.setLineDash([5, 4]);
          ctx.stroke();
          ctx.setLineDash([]);
          ctx.font      = '600 9px Lexend Deca, sans-serif';
          ctx.fillStyle = lineColour;
          ctx.textAlign = 'right';
          ctx.fillText('1x (on estimate)', chartArea.right - 4, y1 - 5);
          ctx.restore();
        }
      }]
    });

  } catch (error) {
    console.error('Failed to render effort accuracy chart:', error);
  }
}


// ============================================================
// TEAM WORKLOAD: Employee card rendering and filtering
// ============================================================

let cachedEmployeeTaskData     = [];
let selectedWorkloadProjectId  = null;

async function getAllEmployeeTasksByProject(projectId) {
  const employees = await getAllEmployeesByProject(projectId);

  const EFFORT_POINTS = { XS: 1, S: 4, M: 8, L: 24, XL: 40 };

  const employeeTaskData = await Promise.all(
    employees.map(async (employee) => {
        const tasks = await getAllTasksByEmployee(employee.employee_id);
      const completedTasks = tasks.filter(task => task.status === "Completed").length;
      const activeTasks    = tasks.filter(task => task.status !== "Completed").length;

      const totalEstimatedEffort = tasks.reduce((sum, task) => {
        return sum + (EFFORT_POINTS[task.estimated_effort] || 0);
      }, 0);

      return { ...employee, completedTasks, activeTasks, totalEstimatedEffort };
    })
  );

  return employeeTaskData;
}

async function renderEmployeeCards(projectId) {
  selectedWorkloadProjectId = projectId;

  const employees = await getAllEmployeeTasksByProject(projectId);

  cachedEmployeeTaskData = employees.map(employee => ({
    ...employee,
    totalTasks: employee.completedTasks + employee.activeTasks,
    totalEstimatedEffort: employee.totalEstimatedEffort ?? 0
  }));

  applyEmployeeFilters();
}

let activeEmployeeSort = 'none';

function applyEmployeeSort(sortKey) {
  activeEmployeeSort = sortKey;
  applyEmployeeFilters();
}

function applyEmployeeFilters() {
  const searchValue = (document.getElementById('employee-search')?.value || '').trim().toLowerCase();

  let filteredEmployees = cachedEmployeeTaskData.filter(employee => {
    const fullName = `${employee.first_name} ${employee.last_name}`.toLowerCase();
    return fullName.includes(searchValue);
  });

  switch (activeEmployeeSort) {
    case 'progress_desc':
    case 'progress_asc':
      filteredEmployees.sort((a, b) => {
        const pctA = a.totalTasks > 0 ? a.completedTasks / a.totalTasks : 0;
        const pctB = b.totalTasks > 0 ? b.completedTasks / b.totalTasks : 0;
        return activeEmployeeSort === 'progress_desc' ? pctB - pctA : pctA - pctB;
      });
      break;
    case 'active_desc':
    case 'active_asc':
      filteredEmployees.sort((a, b) => activeEmployeeSort === 'active_desc'
        ? b.activeTasks - a.activeTasks
        : a.activeTasks - b.activeTasks);
      break;
    case 'completed_desc':
    case 'completed_asc':
      filteredEmployees.sort((a, b) => activeEmployeeSort === 'completed_desc'
        ? b.completedTasks - a.completedTasks
        : a.completedTasks - b.completedTasks);
      break;
    case 'effort_desc':
    case 'effort_asc':
      filteredEmployees.sort((a, b) => activeEmployeeSort === 'effort_desc'
        ? (b.totalEstimatedEffort || 0) - (a.totalEstimatedEffort || 0)
        : (a.totalEstimatedEffort || 0) - (b.totalEstimatedEffort || 0));
      break;
    case 'total_desc':
    case 'total_asc':
      filteredEmployees.sort((a, b) => activeEmployeeSort === 'total_desc'
        ? b.totalTasks - a.totalTasks
        : a.totalTasks - b.totalTasks);
      break;
  }

  buildEmployeeCards(filteredEmployees);
}


function handleEmployeeCardClick(employee) {

  const role = (employee.job_title || employee.role || employee.job_role || '').toLowerCase();

  if (role.includes('manager')) {
    showManagerBlockedToast(employee);
    return;
  }

  window.location.href = `<?= BASE_URL ?>Employee-Analytics-Page/makeitall-Employee-Overview.php?employee_id=${employee.employee_id}`;
}

function showManagerBlockedToast(employee) {

  const existing = document.getElementById('manager-blocked-toast');
  if (existing) existing.remove();

  const name = `${employee.first_name} ${employee.last_name}`;

  const toast = document.createElement('div');
  toast.id = 'manager-blocked-toast';
  toast.innerHTML = `
    <div class="manager-toast-inner">
      <svg class="manager-toast-icon" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
      <div>
        <p class="manager-toast-title">${name} is a manager</p>
        <p class="manager-toast-subtitle">You can't view your manager's analytics.</p>
      </div>
    </div>
  `;

  document.body.appendChild(toast);
  requestAnimationFrame(() => toast.classList.add('is-visible'));

  setTimeout(() => {
    toast.classList.remove('is-visible');
    setTimeout(() => toast.remove(), 300);
  }, 3500);
}




function buildEmployeeCards(employees) {
  const container = document.getElementById('employee-cards-container');
  container.innerHTML = '';

  if (!employees.length) {
    container.innerHTML = `
      <p style="color:#5a6070; font-size:0.9rem; margin-top:16px; text-align:center; width:100%;">
        No employees match your filters.
      </p>
    `;
    return;
  }

  employees.forEach(employee => {
    const totalTasks      = employee.totalTasks ?? (employee.completedTasks + employee.activeTasks);
    const progressPercent = totalTasks > 0 ? Math.round((employee.completedTasks / totalTasks) * 100) : 0;
    const hue = (employee.employee_id * 137) % 360;
    const name            = `${employee.first_name} ${employee.last_name}`;

    const card = document.createElement('div');
    card.className = 'd-flex justify-content-center text-decoration-none';
    card.style.cursor = 'pointer';
    card.addEventListener('click', () => handleEmployeeCardClick(employee));


    card.href = `<?= BASE_URL ?>Employee-Analytics-Page/makeitall-Employee-Overview.php?employee_id=${employee.employee_id}`;

    card.innerHTML = `
      <div class="inner-container rounded-4 p-3" style="width: 360px; cursor: pointer; transition: outline 0.15s;">
        <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
          style="width: 130px; height: 130px; background-color: hsl(${hue}, 55%, 40%);">
          <span style="font-size: 3rem; font-weight: 700; color: #ffffff; font-family: 'Lexend Deca', sans-serif;">
            ${getInitials(name)}
          </span>
        </div>
          <span style="font-size: 1.3rem; font-weight: 500;">${name}</span>
        </div>

        <div class="mt-3">
          <div class="d-flex justify-content-between mb-1">
            <small class="card-subtext">Task Progress</small>
            <small class="card-subtext">${progressPercent}%</small>
          </div>
          <div class="rounded-pill overflow-hidden progress-track" style="height: 20px;">
            <div class="rounded-pill h-100" style="width: ${progressPercent}%; background-color: ${getProgressBarColour(progressPercent)};"></div>
          </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
          <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle stat-dot" style="width: 8px; height: 8px;"></div>
            <small class="card-subtext">Active Tasks: <span class="card-subtext" style="font-weight: 600;">${employee.activeTasks}</span></small>
          </div>
          <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle stat-dot" style="width: 8px; height: 8px;"></div>
            <small class="card-subtext">Complete Tasks: <span class="card-subtext" style="font-weight: 600;">${employee.completedTasks}</span></small>
          </div>
        </div>

        <div class="mt-2 d-flex justify-content-between align-items-center">
          <small class="card-subtext">Total Tasks: <span card-subtext style="font-weight:600;">${totalTasks}</span></small>
          <small class="card-subtext">Est. Effort: <span card-subtext style="font-weight:600;">${employee.totalEstimatedEffort ?? 0} pts</span></small>
        </div>
      </div>
    `;

    container.appendChild(card);
  });
}

function toggleEmployeeFilterMenu() {
  const menu   = document.getElementById('employee-filter-menu');
  const isOpen = menu.style.display === 'block';
  menu.style.display = isOpen ? 'none' : 'block';

  if (!isOpen) {
    setTimeout(() => {
      document.addEventListener('click', closeEmployeeFilterMenuOnOutsideClick);
    }, 0);
  }
}

function closeEmployeeFilterMenuOnOutsideClick(e) {
  const menu = document.getElementById('employee-filter-menu');
  const btn  = document.getElementById('employee-filter-btn');

  if (!menu.contains(e.target) && !btn.contains(e.target)) {
    menu.style.display = 'none';
    document.removeEventListener('click', closeEmployeeFilterMenuOnOutsideClick);
  }
}

// ============================================================
// CAROUSEL: Chart panel slide controller
// ============================================================

let currentChartIndex = 0;
const CHART_COUNT = 2;

function goToChart(index) {
  document.getElementById(`chart-slide-${currentChartIndex}`).style.display = 'none';
  currentChartIndex = index;
  document.getElementById(`chart-slide-${currentChartIndex}`).style.display = 'block';
  updateChartDots();

  const desc = managerChartDescriptions[index];
  document.querySelector('#manager-chart-info-popup .popup-title').textContent = desc.title;
  document.querySelector('#manager-chart-info-popup .popup-body').textContent  = desc.body;
}

function prevChart() {
  goToChart((currentChartIndex - 1 + CHART_COUNT) % CHART_COUNT);
}

function nextChart() {
  goToChart((currentChartIndex + 1) % CHART_COUNT);
}

function updateChartDots() {
  for (let i = 0; i < CHART_COUNT; i++) {
    const pill = document.getElementById(`chart-pill-${i}`);
    if (!pill) continue;
    pill.classList.toggle('active', i === currentChartIndex);
  }
}

loadProjects();
renderProjectProgressChart(true);
renderEffortAccuracyChart(projectId);
renderEmployeeCards(projectId);


</script>
</html>