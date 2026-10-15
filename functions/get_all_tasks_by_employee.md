# get_all_tasks_by_employee

## Purpose
Returns all tasks assigned to a specific employee, including dependency information for each task.

This endpoint is intended for the employee dashboard.

## Endpoint
`GET /api/get_all_tasks_by_employee.php`

## Query Parameters
- `employee_id` (required, integer)

## Example Request
`/api/get_all_tasks_by_employee.php?employee_id=5`

## Example Success Response
```json
{
  "success": true,
  "data": {
    "employee_id": 5,
    "total_tasks": 2,
    "tasks": [
      {
        "task_id": 101,
        "project_id": 7,
        "project_name": "Website Redesign",
        "assigner_id": 2,
        "assignee_id": 5,
        "assigner_name": "Sarah Ahmed",
        "title": "Create homepage wireframes",
        "description": "Produce initial homepage wireframe options",
        "status": "In Progress",
        "created_date": "2026-03-20 09:00:00",
        "due_date": "2026-03-28 17:00:00",
        "priority": "High",
        "estimated_effort": "M",
        "task_type": "project",
        "started_date": "2026-03-21 10:00:00",
        "submitted_date": null,
        "completed_date": null,
        "completion_wait_time": null,
        "completed_by_id": null,
        "completed_by_name": "",
        "visibility": 1,
        "dependencies": [
          {
            "dependency_id": 99,
            "dependency_title": "Approve homepage layout",
            "dependency_status": "Completed",
            "dependency_due_date": "2026-03-22 12:00:00",
            "dependency_project_id": 7
          }
        ],
        "dependency_count": 1
      },
      {
        "task_id": 102,
        "project_id": null,
        "project_name": null,
        "assigner_id": 2,
        "assignee_id": 5,
        "assigner_name": "Sarah Ahmed",
        "title": "Update personal notes",
        "description": "Organise private planning notes",
        "status": "Not Started",
        "created_date": "2026-03-20 12:00:00",
        "due_date": null,
        "priority": "Low",
        "estimated_effort": "XS",
        "task_type": "private",
        "started_date": null,
        "submitted_date": null,
        "completed_date": null,
        "completion_wait_time": null,
        "completed_by_id": null,
        "completed_by_name": "",
        "visibility": 1,
        "dependencies": [],
        "dependency_count": 0
      }
    ]
  }
}
```

## Ordering

## Tasks are ordered by
- incomplete tasks first
- due date ascending
- created date ascending
- task ID ascending
Tasks with NULL due dates are placed last among incomplete tasks.


Frontend Notes
Use a GET request
Pass the employee ID as employee_id
Read the task list from data.tasks
Use dependency_count to display dependency badges or warning indicators
Use the dependencies array to display prerequisite tasks in the UI

```javascript
async function getAllTasksByEmployee(employeeId) {
  const response = await fetch(`/api/get_all_tasks_by_employee.php?employee_id=${employeeId}`);
  const result = await response.json();

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data.tasks;
}
```