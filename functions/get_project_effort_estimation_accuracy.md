# get_project_effort_estimation_accuracy

## Purpose
Returns effort estimation data for all project tasks in a project, with an optional employee filter.

This endpoint provides both:

- estimated effort
- actual effort

for each task in the project.

## Endpoint
`GET /api/get_project_effort_estimation_accuracy.php`

## Query Parameters
- `project_id` (required, integer)
- `employee_id` (optional, integer)

## Behaviour
- If only `project_id` is provided, the endpoint returns all project tasks in that project.
- If `employee_id` is also provided, the endpoint only includes tasks assigned to that employee.

## Task Inclusion Rules
- Only tasks where `task_type = 'project'` are included

## Estimated Effort Mapping
The `estimated_effort` values are converted to hours as follows:

- `XS` = 1
- `S` = 4
- `M` = 8
- `L` = 24
- `XL` = 40

## Actual Effort Formula
Actual effort is calculated only for tasks where both `started_date` and `completed_date` are present.

Formula:

```text
actual effort =
(completed_date - started_date)
- completion_wait_time

## Example Request: whole project
```text
/api/get_project_effort_estimation_accuracy.php?project_id=7
```

actual_effort_time: calculated actual effort in HH:MM:SS format, where hours may exceed 24
total_actual_effort_time: summed actual effort in HH:MM:SS format, where hours may exceed 24

## Example Request: filtered by employee
```text
/api/get_project_effort_estimation_accuracy.php?project_id=7&employee_id=5
```

## Example Success Response
```json
{
  "success": true,
  "data": {
    "project_id": 7,
    "project_name": "Website Redesign",
    "employee_id": 5,
    "total_tasks": 2,
    "completed_tasks": 1,
    "total_estimated_effort_hours": 12,
    "total_actual_effort_seconds": 18000,
    "total_actual_effort_time": "05:00:00",
    "total_actual_effort_hours": 5,
    "project_variance_hours": -7,
    "tasks": [
      {
        "task_id": 101,
        "project_id": 7,
        "assignee_id": 5,
        "assignee_name": "John Smith",
        "title": "Create homepage wireframes",
        "status": "Completed",
        "estimated_effort": "M",
        "estimated_effort_hours": 8,
        "started_date": "2026-03-20 09:00:00",
        "submitted_date": "2026-03-21 14:00:00",
        "completed_date": "2026-03-21 17:00:00",
        "completion_wait_time": "01:00:00",
        "actual_effort_seconds": 111600,
        "actual_effort_time": "31:00:00",
        "actual_effort_hours": 31,
        "variance_hours": 23
      },
      {
        "task_id": 102,
        "project_id": 7,
        "assignee_id": 5,
        "assignee_name": "John Smith",
        "title": "Write project summary",
        "status": "In Progress",
        "estimated_effort": "S",
        "estimated_effort_hours": 4,
        "started_date": "2026-03-22 10:00:00",
        "submitted_date": null,
        "completed_date": null,
        "completion_wait_time": null,
        "actual_effort_seconds": null,
        "actual_effort_time": null,
        "actual_effort_hours": null,
        "variance_hours": null
      }
    ]
  }
}
```

Frontend Notes
Use a GET request
Always pass project_id
Pass employee_id only when filtering to one employee
Use data.tasks to render per-task estimated vs actual comparisons
Use the top-level totals for summary cards or charts

## Example JavaScript usage
```javascript
async function getProjectEffortEstimationAccuracy(projectId, employeeId = null) {
  let url = `/api/get_project_effort_estimation_accuracy.php?project_id=${projectId}`;

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

## Reuse
### This endpoint can be reused for:
- Project Page Effort Estimation Accuracy
- Manager Dashboard Effort Estimation Accuracy

