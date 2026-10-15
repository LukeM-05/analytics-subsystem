# login_employee

## Purpose
Checks whether an employee's email and password match a row in the `Employees` table.

If the credentials are valid, the API returns the employee's `employee_id`.

## Endpoint
`POST /api/login_employee.php`

## Request Format
This endpoint accepts either:

- `application/json`
- standard form POST data

## Required Fields
- `email` (string, required)
- `password` (string, required)

## Example JSON Request
```json
{
  "email": "john.smith@example.com",
  "password": "MyPlainTextPassword"
}
```

## Frontend Notes 
- Use POST request
- Send email and password
- On success, read the employee id from data.employee_id
- On failure, read the error message from error 