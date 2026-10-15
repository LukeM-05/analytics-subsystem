# get_all_tasks_by_project

## Purpose
Returns all tasks for a specific project from the `Tasks` table.

This endpoint is intended for the project page task list and can also be reused later for Gantt chart-related features.

## Endpoint
`GET /api/get_all_tasks_by_project.php`

## Query Parameters
- `project_id` (required, integer)

## Example Request
`/api/get_all_tasks_by_project.php?project_id=7`

## Example Success Response
```json
{
  "success": true,
  "data": {
    "project_id": 7,
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
        "task_type": "project",
        "started_date": "2026-03-21 10:00:00",
        "submitted_date": null,
        "completed_date": null,
        "completion_wait_time": null,
        "completed_by_id": null,
        "visibility": 1
      },
      {
        "task_id": 102,
        "project_id": 7,
        "assigner_id": 2,
        "assignee_id": 6,
        "assigner_name": "Sarah Ahmed",
        "assignee_name": "Emily Jones",
        "title": "Write project summary",
        "description": "Draft the initial summary for stakeholders",
        "status": "Not Started",
        "created_date": "2026-03-20 09:15:00",
        "due_date": "2026-03-26 17:00:00",
        "priority": "Medium",
        "estimated_effort": "S",
        "task_type": "project",
        "started_date": null,
        "submitted_date": null,
        "completed_date": null,
        "completion_wait_time": null,
        "completed_by_id": null,
        "visibility": 1
      }
    ]
  }
}
```

## Ordering
### Tasks are ordering by:
- due_date ascending
- created_date ascending
- task_id ascending
Tasks with null due dates are placed last

## Frontend Notes
- Use a GET request
- Pass the project ID as project_id
- Read the returned tasks from data.tasks
- Use data.total_tasks for task counts
- This endpoint is suitable for task tables and task list views
- A later Gantt chart endpoint may extend this data with dependency information

## Example JavaScript Usage
```javascript
async function getAllTasksByProject(projectId) {
  const response = await fetch(`/api/get_all_tasks_by_project.php?project_id=${projectId}`);
  const result = await response.json();

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data.tasks;
}
```
