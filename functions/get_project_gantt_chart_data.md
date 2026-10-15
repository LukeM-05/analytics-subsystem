# get_project_gantt_chart_data

## Purpose
Returns Gantt-chart-ready task data for a project.

This endpoint is designed for the project page. It returns the project details and all project tasks in a format that the frontend can use to render a Gantt chart.

## Endpoint
`GET /api/get_project_gantt_chart_data.php`

## Query Parameters
- `project_id` (required, integer)
- `employee_id` (optional, integer)

## Behaviour
- If only `project_id` is provided, all project tasks are returned.
- If `employee_id` is also provided, only tasks assigned to that employee are returned.

## Task Inclusion Rules
- Only tasks where `task_type = 'project'` are included.

## Returned Project Fields
The `project` object includes:
- `project_id`
- `name`
- `status`
- `start_date`
- `due_date`
- `summary`
- `milestone`
- `teamleader_id`

## Returned Task Fields
Each task object includes:
- all major task fields from the `Tasks` table
- `assigner_name`
- `assignee_name`
- `estimated_effort_hours`
- `actual_effort_seconds`
- `actual_effort_time`
- `actual_effort_hours`
- `progress_percentage`
- `gantt_start_date`
- `gantt_end_date`
- `dependency_ids`
- `dependencies`

## Gantt Date Rules

### gantt_start_date
Chosen in this order:
1. `started_date`
2. `created_date`
3. project `start_date`

### gantt_end_date
Chosen in this order:
1. `completed_date`
2. `due_date`
3. project `due_date`

These fallback rules help the frontend render chart bars even when some workflow dates are missing.

## Progress Percentage Rules
Because the database does not store an explicit percentage-complete field, this endpoint derives progress from task status:

- `Not Started` = `0`
- `In Progress` = `50`
- `Awaiting Validation` = `90`
- `Completed` = `100`

## Dependencies
Dependencies are read from the `Task_dependency` table.

Interpretation:
- `task_id` = current task
- `dependency_id` = a task that must be completed first

Each task returns:
- `dependency_ids`: array of dependency task IDs
- `dependencies`: array of dependency objects including title and status

## Example Request: whole project
`/api/get_project_gantt_chart_data.php?project_id=7`

## Example Request: filtered by employee
`/api/get_project_gantt_chart_data.php?project_id=7&employee_id=5`

## Example Success Response
```json
{
  "success": true,
  "data": {
    "project": {
      "project_id": 7,
      "name": "Website Redesign",
      "status": "On Time",
      "start_date": "2026-03-01 09:00:00",
      "due_date": "2026-04-15 17:00:00",
      "summary": "Redesign the client-facing website",
      "milestone": "Beta launch",
      "teamleader_id": 2
    },
    "employee_id": 5,
    "total_tasks": 2,
    "tasks": [
      {
        "task_id": 101,
        "project_id": 7,
        "assigner_id": 2,
        "assignee_id": 5,
        "assigner_name": "Sarah Ahmed",
        "assignee_name": "John Smith",
        "title": "Create homepage wireframes",
        "description": "Produce initial homepage wireframe options",
        "status": "In Progress",
        "created_date": "2026-03-20 09:00:00",
        "due_date": "2026-03-28 17:00:00",
        "priority": "High",
        "estimated_effort": "M",
        "estimated_effort_hours": 8,
        "task_type": "project",
        "started_date": "2026-03-21 10:00:00",
        "submitted_date": null,
        "completed_date": null,
        "completion_wait_time": null,
        "completed_by_id": null,
        "visibility": 1,
        "actual_effort_seconds": null,
        "actual_effort_time": null,
        "actual_effort_hours": null,
        "progress_percentage": 50,
        "gantt_start_date": "2026-03-21 10:00:00",
        "gantt_end_date": "2026-03-28 17:00:00",
        "dependency_ids": [99],
        "dependencies": [
          {
            "dependency_id": 99,
            "dependency_title": "Approve homepage layout",
            "dependency_status": "Completed"
          }
        ]
      }
    ]
  }
}
```

2. What this function does

It returns Gantt-ready project data.

Project-level data

It returns the main project details:

project_id
name
status
start_date
due_date
summary
milestone
teamleader_id
Task-level data

For each project task, it returns:

all major task fields
assigner and assignee names
estimated effort in hours
actual effort
a derived progress percentage
dependency IDs and dependency objects
a gantt_start_date
a gantt_end_date
Optional employee filter

If you pass an employee_id, it only returns tasks for that assignee.

That means the same endpoint can be used for:

full project Gantt chart
project Gantt chart filtered to one employee
3. How the Gantt dates are chosen

Because not every task will always have full live workflow dates, the function gives the frontend two chart-friendly fields:

gantt_start_date

Chosen in this order:

started_date
created_date
project start_date
gantt_end_date

Chosen in this order:

completed_date
due_date
project due_date

This gives the chart something usable even when a task is not complete yet.

4. How progress is derived

Since your schema does not appear to store task percentage completion directly, this function derives it from status:

Not Started → 0
In Progress → 50
Awaiting Validation → 90
Completed → 100

This is a practical default for Gantt rendering.




Empty Results

If the project exists but has no matching project tasks, the endpoint still returns success with:

total_tasks = 0
tasks = []
Frontend Notes
Use a GET request
Always send project_id
Send employee_id only when filtering by assignee
Use gantt_start_date and gantt_end_date for the task bar positions
Use progress_percentage for the task progress fill
Use dependency_ids if the Gantt component expects predecessor IDs
Use dependencies if the UI needs to display dependency details



## Example JavaScript Usage
```javascript
async function getProjectGanttChartData(projectId, employeeId = null) {
  let url = `/api/get_project_gantt_chart_data.php?project_id=${projectId}`;

  if (employeeId !== null) {
    url += `&employee_id=${employeeId}`;
  }

  const response = await fetch(url);
  const result = await response.json();

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data;
}
```
