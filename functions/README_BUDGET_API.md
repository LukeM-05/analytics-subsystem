# Budget API Overview

## Purpose
This API supports project-level budget tracking using a transaction ledger.

The ledger records:
- budget allocations
- budget increases
- budget decreases
- expenses
- refunds

## Data Model
Main table:
- `Project_Budget_Transactions`

Linked tables:
- `Projects`
- `Employees`

## Core Rule
Amounts are stored as positive values.

Whether a transaction adds to or subtracts from the budget is determined by `transaction_type`.

## Transaction Types

### Adds to budget
- `allocation`
- `adjustment_increase`
- `refund`

### Subtracts from budget
- `adjustment_decrease`
- `expense`

## Available Endpoints
- `POST /api/create_project_budget_transaction.php`
- `GET /api/get_project_budget_summary.php`
- `GET /api/get_project_budget_transactions.php`

## Suggested UI Usage
- Use `get_project_budget_summary` for project budget summary cards
- Use `get_project_budget_transactions` for the ledger table
- Use `create_project_budget_transaction` when recording new budget events

## One note
- this version assumes reciept_path is just a string
- if you want me to do anything to change that 
    - # my payment comes in the form of boxes of monster ultra 

