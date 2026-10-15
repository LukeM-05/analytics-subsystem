# API Overview

## Purpose
This API provides employee data for the website frontend.

## Architecture
- Database: MySQL
- Backend: PHP
- Response format: JSON

## General Rules
- All endpoints return JSON
- All read endpoints use GET
- All IDs must be positive integers
- Success responses include `"success": true`
- Error responses include `"success": false`

## Base Endpoint Pattern
Example:
`/api/get_employee_role_type.php?employee_id=1`

## Standard Success Response
```json
{
  "success": true,
  "data": {}
}
```

## Example function of how to use the api function
```javascript
async function loadRoleType(employeeId) {
  const response = await fetch(`/api/get_employee_role_type.php?employee_id=${employeeId}`);
  const result = await response.json();

  if (!result.success) {
    throw new Error(result.error);
  }

  return result.data.role_type;
}
```