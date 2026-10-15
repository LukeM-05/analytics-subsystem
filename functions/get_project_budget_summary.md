# get_project_budget_summary

## Purpose
Returns the current budget summary for a project based on the full transaction ledger.

This endpoint does not depend on a stored `remaining_budget` column. Instead, it calculates the budget state directly from `Project_Budget_Transactions`.

## Endpoint
`GET /api/get_project_budget_summary.php`

## Query Parameters
- `project_id` (required, integer)

## Example Request
`/api/get_project_budget_summary.php?project_id=7`

## Example Success Response
```json
{
  "success": true,
  "data": {
    "project_id": 7,
    "project_name": "Website Redesign",
    "total_transactions": 5,
    "original_budget": 10000,
    "adjustment_increase_total": 500,
    "adjustment_decrease_total": 100,
    "approved_budget": 10400,
    "expense_total": 1200.75,
    "refund_total": 50,
    "net_spent": 1150.75,
    "remaining_budget": 9249.25,
    "spent_percentage_of_approved_budget": 11.06,
    "is_over_budget": false
  }
}
```
## Formula Details
### Original Budget
- sum of all allocation transactions

### Approved Budget
- original budget + adjustment increases - adjustment decreases

### Net Spent
- expense total - refund total

### Remaining Budget
- approved budget - net spent

### Spent percentage of approved budget
- (net spent / approved budget) * 100

## Field Meanings
project_id: project ID
project_name: project name
total_transactions: number of budget transactions recorded for the project
original_budget: total initial allocation amount
adjustment_increase_total: total of all positive budget adjustments
adjustment_decrease_total: total of all negative budget adjustments
approved_budget: current approved budget after adjustments
expense_total: total of all expense transactions
refund_total: total of all refund transactions
net_spent: expense total minus refund total
remaining_budget: amount still available
spent_percentage_of_approved_budget: how much of the approved budget has been spent
is_over_budget: true when remaining budget is below zero


## Behaviour When There Are No Transactions

If the project exists but has no budget transactions yet, the endpoint still returns success.

All totals will be 0, and:

remaining_budget will be 0
is_over_budget will be false


## Frontend Notes
Use this endpoint for project-level budget cards and summary panels
Good UI fields to highlight are:
approved_budget
net_spent
remaining_budget
spent_percentage_of_approved_budget
is_over_budget