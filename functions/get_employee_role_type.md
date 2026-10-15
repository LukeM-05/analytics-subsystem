# get_employee_role_type

## Purpose
Returns the role type for a specific employee.

## Endpoint
`GET /api/get_employee_role_type.php`

## Query Parameters
- `employee_id` (required, integer)

## Example Request
`/api/get_employee_role_type.php?employee_id=1`

## Example Success Response
```json
{
  "success": true,
  "data": {
    "employee_id": 1,
    "role_type": "Manager"
  }
}