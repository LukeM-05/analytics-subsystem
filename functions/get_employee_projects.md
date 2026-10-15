# get_employee_projects

## Purpose
Returns all projects assigned to a specific employee.

This endpoint reads project membership from the `Project_Assignment` table and returns the related project details from the `Projects` table.

## Endpoint
`GET /api/get_employee_projects.php`

## Query Parameters
- `employee_id` (required, integer)

## Example Request
`/api/get_employee_projects.php?employee_id=5`

## Example Success Response
```json
{
  "success": true,
  "data": {
    "employee_id": 5,
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
        "visibility": 1,
        "created_by": 2,
        "conversation_id": 14
      },
      {
        "project_id": 9,
        "name": "Mobile App Refresh",
        "status": "Behind Schedule",
        "start_date": "2026-02-10 09:00:00",
        "due_date": "2026-05-01 17:00:00",
        "summary": "Refresh the mobile application UI",
        "milestone": "Internal review",
        "risk_level": "High",
        "risk_desc": "Design handoff delays",
        "teamleader_id": 6,
        "teamleader_name": "Emily Jones",
        "visibility": 1,
        "created_by": 1,
        "conversation_id": 19
      }
    ]
  }
}
```
Ordering

Projects are ordered by:

Behind Schedule
On Time
Ahead of Schedule
any other status values
due date ascending
start date ascending
project ID ascending

```javascript
async function getEmployeeProjects(employeeId) {
  const response = await fetch(`/api/get_employee_projects.php?employee_id=${employeeId}`);
  const result = await response.json();

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data.projects;
}
```