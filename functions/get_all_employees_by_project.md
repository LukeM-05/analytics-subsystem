# get_all_employees_by_project

## Purpose
Returns all employees assigned to a specific project.

This endpoint reads project membership from the `Project_Assignment` table and returns employee details from the `Employees` table.

## Endpoint
`GET /api/get_all_employees_by_project.php`

## Query Parameters
- `project_id` (required, integer)

## Example Request
`/api/get_all_employees_by_project.php?project_id=7`

## Example Success Response
```json
{
  "success": true,
  "data": {
    "project_id": 7,
    "total_employees": 2,
    "employees": [
      {
        "employee_id": 5,
        "first_name": "John",
        "last_name": "Smith",
        "full_name": "John Smith",
        "email": "john.smith@example.com",
        "role_type": "employee",
        "job_title": "Frontend Developer",
        "manager_id": 2,
        "status": "online",
        "last_login": "2026-03-24 09:15:00",
        "created_at": "2026-01-10 08:00:00",
        "visibility": 1,
        "is_teamleader": 0
      },
      {
        "employee_id": 2,
        "first_name": "Sarah",
        "last_name": "Ahmed",
        "full_name": "Sarah Ahmed",
        "email": "sarah.ahmed@example.com",
        "role_type": "teamLeader",
        "job_title": "Project Lead",
        "manager_id": null,
        "status": "busy",
        "last_login": "2026-03-24 08:55:00",
        "created_at": "2025-11-01 10:00:00",
        "visibility": 1,
        "is_teamleader": 1
      }
    ]
  }
}
```

## Ordering

### Employees are ordered by:

1- team leader first
2- first name ascending
3- last name ascending
4- employee ID ascending

## Frontend Notes
- Use a GET request
- Pass the project ID as project_id
- Read the returned employees from data.employees
- Use data.total_employees for employee counts
- Use is_teamleader to highlight the project lead in the UI

```javascript
async function getAllEmployeesByProject(projectId) {
  const response = await fetch(`/api/get_all_employees_by_project.php?project_id=${projectId}`);
  const result = await response.json();

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data.employees;
}
```