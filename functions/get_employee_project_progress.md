# get_employee_project_progress

## Purpose
Calculates an employee's project progress variance for a specific project.

The formula used is:

```text
(completed estimated effort / total estimated effort) - (elapsed project time / total project duration)
```
## Estimated Effort Mapping

### The estimated_effort values in the Tasks table are converted to hours as follows:

- XS = 1
- S = 4
- M = 8
- L = 24
- XL = 40

## Data Source Rules

- Tasks are read from the Tasks table
- The employee is matched using assignee_id
- The project is matched using project_id
- Only tasks with task_type = 'project' are included
- A task is treated as completed when completed_date IS NOT NULL
- Project timing is read from the Projects table using:
    - start_date
    - due_date

## Endpoint

GET /api/get_employee_project_progress_variance.php

### Query Parameters

- employee_id (required, integer)
- project_id (required, integer)

### Example Request
/api/get_employee_project_progress_variance.php?employee_id=3&project_id=7

## Example Success Response 
```json
{
  "success": true,
  "data": {
    "employee_id": 3,
    "project_id": 7,
    "completed_effort_hours": 12,
    "total_effort_hours": 40,
    "completed_effort_ratio": 0.3,
    "elapsed_time_ratio": 0.45,
    "result": -15
  }
}
```

## Example Error Responses
### Missing or invalid employee_id
```json
{
  "success": false,
  "error": "employee_id must be provided as a positive integer."
}
```

### Missing or invalid project_id
```json
{
  "success": false,
  "error": "project_id must be provided as a positive integer."
}
```

### No Matching Data Found
```json
{
  "success": false,
  "error": "No matching project task data found, or the project dates are invalid."
}
```

### Wrong request method
```json
{
  "success": false,
  "error": "Method not allowed. Use GET."
}
```

## Frontend Notes

- Use a GET request
- Pass both employee_id and project_id
- Read the final score from data.result
- The frontend may also display the detailed fields:
    - data.completed_effort_hours
    - data.total_effort_hours
    - data.completed_effort_ratio
    - data.elapsed_time_ratio

## Example JavaScript Usage
```javascript
async function getEmployeeProjectProgressVariance(employeeId, projectId) {
  const response = await fetch(
    `/api/get_employee_project_progress.php?employee_id=${employeeId}&project_id=${projectId}`
  );

  const result = await response.json();

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data;
}
```