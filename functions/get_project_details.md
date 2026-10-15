# get_project_details

## Purpose
Returns the details for a single project from the `Projects` table.

## Endpoint
`GET /api/get_project_details.php`

## Query Parameters
- `project_id` (required, integer)

## Example Request
`/api/get_project_details.php?project_id=3`

## Example Success Response
```json
{
  "success": true,
  "data": {
    "project_id": 3,
    "name": "Website Redesign",
    "status": "On Time",
    "start_date": "2026-03-01 09:00:00",
    "due_date": "2026-04-15 17:00:00",
    "summary": "Redesign the client-facing website",
    "milestone": "Beta launch",
    "risk_level": "Medium",
    "risk_desc": "Tight timeline for testing",
    "teamleader_id": 5,
    "visibility": 1,
    "created_by": 2,
    "conversation_id": 14
  }
}
```

## Frontend Notes
- Use a GET request
- Pass the project ID as project_id
- Read the project details from data

## Example JavaScript Usage
```javascript
async function getProjectDetails(projectId) {
  const response = await fetch(`/api/get_project_details.php?project_id=${projectId}`);
  const result = await response.json();

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data;
}
```
