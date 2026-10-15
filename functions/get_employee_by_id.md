# get_employee

## Purpose
Returns the main employee details for a specific employee.

## Endpoint
`GET /api/get_employee.php`

## Query Parameters
- `employee_id` (required, integer)

## Example Request
`/api/get_employee_by_id.php?employee_id=1`

## Example Success Response
```json
{
  "success": true,
  "data": {
    "employee_id": 1,
    "first_name": "John",
    "last_name": "Smith",
    "role_type": "Manager"
  }
}
```
## Example Error Response

### Missing or Invalid employee_id
```json
{
  "success": false,
  "error": "employee_id must be provided as a positive integer."
}
```
### Employee Not Found
```json
{
  "success": false,
  "error": "Employee not found."
}
```