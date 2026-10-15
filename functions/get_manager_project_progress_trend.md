# get_manager_project_progress_trend

## Purpose
Returns manager-dashboard project progress data for graphing and filtering.

This version returns a **current snapshot** of project progress for all matching projects. It is suitable for graphs that show `% progress for all active projects`.

It does **not** return historical time-series trend points over multiple dates.

## Endpoint
`GET /api/get_manager_project_progress_trend.php`

## Query Parameters
- `search` (optional, string)
- `teamleader_id` (optional, integer)
- `min_progress` (optional, numeric)
- `max_progress` (optional, numeric)
- `active_only` (optional, `1` or `0`, default `1`)

## Current Progress Logic
This endpoint uses **team progress** based on project tasks.

### Included tasks
- Only tasks where `task_type = 'project'` are included

### Completed tasks
- A task is treated as completed when `completed_date IS NOT NULL`

### Estimated effort mapping
- `XS` = 1
- `S` = 4
- `M` = 8
- `L` = 24
- `XL` = 40

### Team progress formula
Primary formula:

```text
team_progress_percentage =
(completed estimated effort hours / total estimated effort hours) * 100
```

### Fallback rule:
- if total estimated effort is 0 but tasks exist, the endpoint falls back to:
    - completed tasks / total tasks *100

### Active Project Rule
- A project is considered active when:
    - team_progress_percentage < 100
    - if active_only = 1, onlt those projects are returned 

## Filtering
search 

matches against:
- project name
- project summary

teamleader_id 
Only returns projects where Projects.teamleader_id mathches the given id 

min_progress
Only returns projects with progress greater than or equal to this value 

max_progress 
Only returns projects with progress less than or equal to this value 

## Example request
```text
/api/get_manager_project_progress_trend.php
```

## Example request with filters
```text
/api/get_manager_project_progress_trend.php?search=website&teamleader_id=2&min_progress=10&max_progress=80&active_only=1
```

## Example Success Response
```json
{
  "success": true,
  "data": {
    "filters": {
      "search": "website",
      "teamleader_id": 2,
      "min_progress": 10,
      "max_progress": 80,
      "active_only": true
    },
    "total_projects": 2,
    "projects": [
      {
        "project_id": 7,
        "name": "Website Redesign",
        "status": "On Time",
        "start_date": "2026-03-01 09:00:00",
        "due_date": "2026-04-15 17:00:00",
        "summary": "Redesign the client-facing website",
        "milestone": "Beta launch",
        "risk_level": "Medium",
        "risk_desc": "Tight testing timeline",
        "teamleader_id": 2,
        "teamleader_name": "Sarah Ahmed",
        "total_tasks": 8,
        "completed_tasks": 3,
        "total_estimated_effort_hours": 72,
        "completed_estimated_effort_hours": 24,
        "team_progress_ratio": 0.3333,
        "team_progress_percentage": 33.33,
        "is_active": true
      },
      {
        "project_id": 9,
        "name": "Website Accessibility Review",
        "status": "Behind Schedule",
        "start_date": "2026-03-10 09:00:00",
        "due_date": "2026-04-01 17:00:00",
        "summary": "Accessibility improvements and audit fixes",
        "milestone": "Internal review",
        "risk_level": "High",
        "risk_desc": "Delayed QA signoff",
        "teamleader_id": 2,
        "teamleader_name": "Sarah Ahmed",
        "total_tasks": 6,
        "completed_tasks": 1,
        "total_estimated_effort_hours": 40,
        "completed_estimated_effort_hours": 4,
        "team_progress_ratio": 0.1,
        "team_progress_percentage": 10,
        "is_active": true
      }
    ],
    "chart_data": [
      {
        "project_id": 9,
        "label": "Website Accessibility Review",
        "teamleader_id": 2,
        "teamleader_name": "Sarah Ahmed",
        "value": 10
      },
      {
        "project_id": 7,
        "label": "Website Redesign",
        "teamleader_id": 2,
        "teamleader_name": "Sarah Ahmed",
        "value": 33.33
      }
    ]
  }
}
```


Response Structure
filters

Echoes back the filters that were applied.

projects

Detailed project rows for cards, tables, and drill-down views.

Each project object includes:

project_id
name
status
start_date
due_date
summary
milestone
risk_level
risk_desc
teamleader_id
teamleader_name
total_tasks
completed_tasks
total_estimated_effort_hours
completed_estimated_effort_hours
team_progress_ratio
team_progress_percentage
is_active
chart_data

A simplified list for plotting a graph.

Each chart data object includes:

project_id
label — project name
teamleader_id
teamleader_name
value — project progress percentage
Ordering

Returned projects are sorted by:

lower progress percentage first
earlier due date first
project name

This helps surface the most at-risk projects near the top.




## Frontend Notes 
- Use data.chart_data for the graph
- Use data.projects for the table or project list underneath the graph 
- Keep active_only=1 for the default manager dashboard view
- set active_only=0 if the fronend needs to include completed projects too 

## Example JavaScript Usage
```javascript
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

  const response = await fetch(`/api/get_manager_project_progress_trend.php?${params.toString()}`);
  const result = await response.json();

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data;
}
```