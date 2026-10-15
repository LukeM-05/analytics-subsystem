# get_project_budget_transactions

## Purpose
Returns the full budget ledger for a project.

This endpoint is intended for ledger tables, audit views, and project budget history pages.

It also returns the same summary information as the summary endpoint, plus a calculated running balance for each row.

## Endpoint
`GET /api/get_project_budget_transactions.php`

## Query Parameters
- `project_id` (required, integer)

## Example Request
`/api/get_project_budget_transactions.php?project_id=7`

## Example Success Response
```json
{
  "success": true,
  "data": {
    "project_id": 7,
    "project_name": "Website Redesign",
    "summary": {
      "project_id": 7,
      "project_name": "Website Redesign",
      "total_transactions": 3,
      "original_budget": 10000,
      "adjustment_increase_total": 500,
      "adjustment_decrease_total": 0,
      "approved_budget": 10500,
      "expense_total": 120.75,
      "refund_total": 0,
      "net_spent": 120.75,
      "remaining_budget": 10379.25,
      "spent_percentage_of_approved_budget": 1.15,
      "is_over_budget": false
    },
    "total_transactions": 3,
    "transactions": [
      {
        "transaction_id": 1,
        "project_id": 7,
        "transaction_type": "allocation",
        "amount": 10000,
        "signed_amount": 10000,
        "description": "Initial approved budget",
        "receipt_path": null,
        "transaction_date": "2026-03-20 09:00:00",
        "created_at": "2026-03-20 09:00:05",
        "created_by": 2,
        "created_by_name": "Sarah Ahmed",
        "running_balance": 10000
      },
      {
        "transaction_id": 2,
        "project_id": 7,
        "transaction_type": "adjustment_increase",
        "amount": 500,
        "signed_amount": 500,
        "description": "Additional design budget approved",
        "receipt_path": null,
        "transaction_date": "2026-03-22 10:00:00",
        "created_at": "2026-03-22 10:00:03",
        "created_by": 2,
        "created_by_name": "Sarah Ahmed",
        "running_balance": 10500
      },
      {
        "transaction_id": 3,
        "project_id": 7,
        "transaction_type": "expense",
        "amount": 120.75,
        "signed_amount": -120.75,
        "description": "Client meeting travel expense",
        "receipt_path": "/uploads/receipts/receipt_12075.pdf",
        "transaction_date": "2026-03-26 14:30:00",
        "created_at": "2026-03-26 14:35:02",
        "created_by": 5,
        "created_by_name": "John Smith",
        "running_balance": 10379.25
      }
    ]
  }
}
```

## Ordering

Transactions are ordered by:
1. transaction_date ascending
2. transaction_id ascending

This means the running balance is calculated in chronological order.

## Field Meanings
### Top level fields
project_id: project ID
project_name: project name
summary: current budget summary for the project
total_transactions: number of returned transaction rows
transactions: full transaction list

### Transaction Fields
transaction_id: unique transaction ID
project_id: project ID
transaction_type: type of budget event
amount: original positive amount stored in the table
signed_amount: positive or negative impact on the budget
description: optional note
receipt_path: optional receipt path or URL
transaction_date: when the budget event occurred
created_at: when the row was recorded
created_by: employee ID of the creator, if provided
created_by_name: readable employee name, if available
running_balance: balance after this transaction, calculated from the start of the ledger

## Why running balance is calculated
The database does not store a permanent remaining_budget field on each row.

Instead, the API calculates the running balance dynamically from the ledger order. This avoids sync problems when old transactions are corrected or inserted later.

## Behaviour When There Are No Transactions

If the project exists but has no budget transactions yet, the endpoint still returns success.

In that case:
- summary.total_transactions will be 0
- total_transactions will be 0
- transactions will be an empty array

## Frontend Notes
Use this endpoint for:
budget history tables
audit views
project finance detail pages
Use signed_amount to show visually whether a row adds to or subtracts from the budget
Use running_balance for ledger-style displays
Use the top-level summary block for summary cards above the transaction table

