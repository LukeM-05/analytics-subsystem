# update_task_status

## Purpose
Updates a task's status using workflow rules.

This endpoint does more than just update the `status` field. It also updates related fields such as:

- `started_date`
- `submitted_date`
- `completed_date`
- `completed_by_id`
- `completion_wait_time`

depending on the status transition.

## Endpoint
`POST /api/update_task_status.php`

## Request Format
This endpoint accepts either:

- `application/json`
- standard form POST data

## Required Fields
- `task_id` (integer, required)
- `status` (string, required)
- `changed_by_employee_id` (integer, required)

## Example JSON Request
```json
{
  "task_id": 101,
  "status": "In Progress",
  "changed_by_employee_id": 2
}
```

## Workflow Rules
1. Not Started → In Progress
- Updates status
- Sets started_date to the current date/time if it is currently NULL

2. any status → Awaiting Validation
- Updates status
- Sets submitted_date to the current date/time
3. Awaiting Validation → Completed
This is only allowed if the employee making the change is:
- a manager, or
- the team leader of the task's project

When allowed, it:
- updates status
- sets completed_date to the current date/time
- sets completed_by_id to changed_by_employee_id

4. Awaiting Validation → In Progress
This is only allowed if the employee making the change is:
- a manager, or
- the team leader of the task's project

When allowed, it:
- updates status
- sets completion_wait_time to the time difference between submitted_date and the current date/time
- sets submitted_date back to NULL

5. Awaiting Validation → Not Started
This transition is not allowed.

6. Direct move to Completed
A task can only be moved to Completed from Awaiting Validation.

7. Reopening completed tasks
This endpoint does not allow a Completed task to be moved back to another status.


## Example Success Response
```json
{
  "success": true,
  "data": {
    "task_id": 101,
    "old_status": "Awaiting Validation",
    "new_status": "Completed",
    "started_date": "2026-03-24 10:00:00",
    "submitted_date": "2026-03-24 14:00:00",
    "completed_date": "2026-03-24 15:10:00",
    "completion_wait_time": null,
    "completed_by_id": 2
  }
}
```

## Example Error Responses
### Missing or invalid task_id
```json
{
  "success": false,
  "error": "task_id must be provided as a positive integer."
}
```

### Missing Status
```json
{
  "success": false,
  "error": "status is required."
}
```

### Missing or invalid changed_by_employee_id
```json
{
  "success": false,
  "error": "changed_by_employee_id must be provided as a positive integer."
}
```

### Task not found
```json
{
  "success": false,
  "error": "Task not found."
}
```

### Employee Not Found
```json
{
  "success": false,
  "error": "Changing employee was not found."
}
```

### Unauthorised Approval action
```json
{
  "success": false,
  "error": "Only a manager or the project team leader can mark a task as Completed from Awaiting Validation."
}
```

### Invalid reverse transition
```json
{
  "success": false,
  "error": "A task cannot be moved from Awaiting Validation back to Not Started."
}
```

### Invalid direct completion 
```json
{
  "success": false,
  "error": "A task can only be moved to Completed from Awaiting Validation."
}
```

## Frontend Notes
- Use a POST request
- Send:
    - task_id
    - status
    - changed_by_employee_id
- On success, read the updated values from data
- On failure, read the error message from error


## Example JavaScript Usage
```javascript
async function updateTaskStatus(taskId, status, changedByEmployeeId) {
  const response = await fetch('/api/update_task_status.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      task_id: taskId,
      status: status,
      changed_by_employee_id: changedByEmployeeId
    })
  });

  const result = await response.json();

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data;
}
```
