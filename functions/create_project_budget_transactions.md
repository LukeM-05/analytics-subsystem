# create_project_budget_transaction

## Purpose
Creates a new budget ledger transaction for a project.

This endpoint is used to record:
- initial budget allocations
- budget increases
- budget decreases
- expenses
- refunds

Each transaction becomes one row in the `Project_Budget_Transactions` table.

## Endpoint
`POST /api/create_project_budget_transaction.php`

## Request Format
This endpoint accepts either:
- `application/json`
- standard form POST data

## Required Fields
- `project_id` (integer, required)
- `transaction_type` (string, required)
- `amount` (numeric, required)
- `transaction_date` (datetime string, required)

## Optional Fields
- `description` (string, optional)
- `receipt_path` (string, optional)
- `created_by` (integer, optional)

## Allowed Transaction Types
The backend accepts these values:

- `allocation`
- `adjustment_increase`
- `adjustment_decrease`
- `expense`
- `refund`

## Important Amount Rule
`amount` must always be sent as a positive number.

The system decides whether that amount adds to or subtracts from the budget based on `transaction_type`.

### Positive impact transaction types
These add money to the project budget:
- `allocation`
- `adjustment_increase`
- `refund`

### Negative impact transaction types
These subtract money from the project budget:
- `adjustment_decrease`
- `expense`

## Example JSON Request: initial allocation
```json
{
  "project_id": 7,
  "transaction_type": "allocation",
  "amount": 10000.00,
  "transaction_date": "2026-03-25 10:00:00",
  "description": "Initial approved project budget",
  "created_by": 2
}
```

## Example JSON Request: expense
```json
{
  "project_id": 7,
  "transaction_type": "expense",
  "amount": 120.75,
  "transaction_date": "2026-03-26 14:30:00",
  "description": "Client meeting travel expense",
  "receipt_path": "/uploads/receipts/receipt_12075.pdf",
  "created_by": 5
}
```

## Example Success Response
```json
{
  "success": true,
  "data": {
    "transaction": {
      "transaction_id": 14,
      "project_id": 7,
      "transaction_type": "expense",
      "amount": 120.75,
      "signed_amount": -120.75,
      "description": "Client meeting travel expense",
      "receipt_path": "/uploads/receipts/receipt_12075.pdf",
      "transaction_date": "2026-03-26 14:30:00",
      "created_at": "2026-03-26 14:35:02",
      "created_by": 5,
      "created_by_name": "John Smith"
    },
    "summary": {
      "project_id": 7,
      "project_name": "Website Redesign",
      "original_budget": 10000,
      "adjustment_increase_total": 500,
      "adjustment_decrease_total": 0,
      "approved_budget": 10500,
      "expense_total": 120.75,
      "refund_total": 0,
      "remaining_budget": 10379.25
    }
  }
}
```

Response Field Meanings
transaction

The row that was just created.

transaction_id: unique ID of the new transaction
project_id: project the transaction belongs to
transaction_type: the type of budget event
amount: original positive amount stored in the database
signed_amount: positive or negative impact on the budget
description: optional explanation of the transaction
receipt_path: optional receipt file path or URL
transaction_date: when the budget event occurred
created_at: when the row was recorded in the system
created_by: employee ID of the creator, if provided
created_by_name: readable employee name, if available
summary

The latest budget summary after the insert.

original_budget: total of all allocation rows
adjustment_increase_total: total of all adjustment_increase rows
adjustment_decrease_total: total of all adjustment_decrease rows
approved_budget: original budget plus increases minus decreases
expense_total: total of all expense rows
refund_total: total of all refund rows
remaining_budget: approved budget minus expenses plus refunds
Business Notes
This endpoint allows over-budget states. That means remaining_budget may go below zero.
That is useful when you want the system to record what actually happened, even if a project overspent before an adjustment was approved.
receipt_path is just a stored string. This endpoint does not upload the file itself.


## Frontend Notes
Use POST
Always send amount as a positive value
Use one of the exact transaction type strings listed above
If your frontend handles file upload separately, upload the receipt first, then send the saved path as receipt_path