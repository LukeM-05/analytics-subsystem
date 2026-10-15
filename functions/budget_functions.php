<?php

require_once __DIR__ . '/../config/db_config.php';

function getAllowedBudgetTransactionTypes(): array
{
    return [
        'allocation',
        'adjustment_increase',
        'adjustment_decrease',
        'expense',
        'refund'
    ];
}

function getBudgetTransactionSignedAmount(string $transactionType, float $amount): float
{
    switch ($transactionType) {
        case 'allocation':
        case 'adjustment_increase':
        case 'refund':
            return $amount;

        case 'adjustment_decrease':
        case 'expense':
            return -$amount;

        default:
            return 0.0;
    }
}

function createProjectBudgetTransaction(
    int $projectId,
    string $transactionType,
    float $amount,
    string $transactionDate,
    ?string $description = null,
    ?string $receiptPath = null,
    ?int $createdBy = null
): array {
    $pdo = getDbConnection();

    $transactionType = strtolower(trim($transactionType));
    $description = $description !== null ? trim($description) : null;
    $receiptPath = $receiptPath !== null ? trim($receiptPath) : null;

    if ($projectId <= 0) {
        return [
            'success' => false,
            'error' => 'project_id must be a positive integer.'
        ];
    }

    if (!in_array($transactionType, getAllowedBudgetTransactionTypes(), true)) {
        return [
            'success' => false,
            'error' => 'Invalid transaction_type.'
        ];
    }

    if ($amount <= 0) {
        return [
            'success' => false,
            'error' => 'amount must be greater than 0.'
        ];
    }

    if ($createdBy !== null && $createdBy <= 0) {
        return [
            'success' => false,
            'error' => 'created_by must be a positive integer when provided.'
        ];
    }

    try {
        $transactionDateValue = new DateTimeImmutable($transactionDate);
        $transactionDateFormatted = $transactionDateValue->format('Y-m-d H:i:s');
    } catch (Throwable $e) {
        return [
            'success' => false,
            'error' => 'transaction_date is invalid.'
        ];
    }

    try {
        $pdo->beginTransaction();

        $projectStmt = $pdo->prepare("
            SELECT project_id, name
            FROM Projects
            WHERE project_id = :project_id
            LIMIT 1
        ");
        $projectStmt->execute([
            'project_id' => $projectId
        ]);

        $project = $projectStmt->fetch(PDO::FETCH_ASSOC);

        if (!$project) {
            $pdo->rollBack();
            return [
                'success' => false,
                'error' => 'Project not found.'
            ];
        }

        if ($createdBy !== null) {
            $employeeStmt = $pdo->prepare("
                SELECT employee_id
                FROM Employees
                WHERE employee_id = :employee_id
                LIMIT 1
            ");
            $employeeStmt->execute([
                'employee_id' => $createdBy
            ]);

            $employee = $employeeStmt->fetch(PDO::FETCH_ASSOC);

            if (!$employee) {
                $pdo->rollBack();
                return [
                    'success' => false,
                    'error' => 'created_by employee was not found.'
                ];
            }
        }

        $insertStmt = $pdo->prepare("
            INSERT INTO Project_Budget_Transactions (
                project_id,
                transaction_type,
                amount,
                description,
                receipt_path,
                transaction_date,
                created_by
            ) VALUES (
                :project_id,
                :transaction_type,
                :amount,
                :description,
                :receipt_path,
                :transaction_date,
                :created_by
            )
        ");

        $insertStmt->execute([
            'project_id' => $projectId,
            'transaction_type' => $transactionType,
            'amount' => $amount,
            'description' => $description !== '' ? $description : null,
            'receipt_path' => $receiptPath !== '' ? $receiptPath : null,
            'transaction_date' => $transactionDateFormatted,
            'created_by' => $createdBy
        ]);

        $transactionId = (int) $pdo->lastInsertId();

        $rowStmt = $pdo->prepare("
            SELECT
                pbt.transaction_id,
                pbt.project_id,
                pbt.transaction_type,
                pbt.amount,
                pbt.description,
                pbt.receipt_path,
                pbt.transaction_date,
                pbt.created_at,
                pbt.created_by,
                CONCAT(
                    COALESCE(e.first_name, ''),
                    CASE
                        WHEN e.first_name IS NOT NULL AND e.last_name IS NOT NULL THEN ' '
                        ELSE ''
                    END,
                    COALESCE(e.last_name, '')
                ) AS created_by_name
            FROM Project_Budget_Transactions pbt
            LEFT JOIN Employees e
                ON e.employee_id = pbt.created_by
            WHERE pbt.transaction_id = :transaction_id
            LIMIT 1
        ");
        $rowStmt->execute([
            'transaction_id' => $transactionId
        ]);

        $transactionRow = $rowStmt->fetch(PDO::FETCH_ASSOC);

        $summaryStmt = $pdo->prepare("
            SELECT
                COALESCE(SUM(CASE WHEN transaction_type = 'allocation' THEN amount ELSE 0 END), 0) AS original_budget,
                COALESCE(SUM(CASE WHEN transaction_type = 'adjustment_increase' THEN amount ELSE 0 END), 0) AS adjustment_increase_total,
                COALESCE(SUM(CASE WHEN transaction_type = 'adjustment_decrease' THEN amount ELSE 0 END), 0) AS adjustment_decrease_total,
                COALESCE(SUM(CASE WHEN transaction_type = 'expense' THEN amount ELSE 0 END), 0) AS expense_total,
                COALESCE(SUM(CASE WHEN transaction_type = 'refund' THEN amount ELSE 0 END), 0) AS refund_total
            FROM Project_Budget_Transactions
            WHERE project_id = :project_id
        ");
        $summaryStmt->execute([
            'project_id' => $projectId
        ]);

        $summaryRow = $summaryStmt->fetch(PDO::FETCH_ASSOC);

        $originalBudget = (float) ($summaryRow['original_budget'] ?? 0);
        $adjustmentIncreaseTotal = (float) ($summaryRow['adjustment_increase_total'] ?? 0);
        $adjustmentDecreaseTotal = (float) ($summaryRow['adjustment_decrease_total'] ?? 0);
        $expenseTotal = (float) ($summaryRow['expense_total'] ?? 0);
        $refundTotal = (float) ($summaryRow['refund_total'] ?? 0);

        $approvedBudget = $originalBudget + $adjustmentIncreaseTotal - $adjustmentDecreaseTotal;
        $remainingBudget = $approvedBudget - $expenseTotal + $refundTotal;

        $pdo->commit();

        return [
            'success' => true,
            'data' => [
                'transaction' => [
                    'transaction_id' => (int) $transactionRow['transaction_id'],
                    'project_id' => (int) $transactionRow['project_id'],
                    'transaction_type' => $transactionRow['transaction_type'],
                    'amount' => (float) $transactionRow['amount'],
                    'signed_amount' => getBudgetTransactionSignedAmount(
                        $transactionRow['transaction_type'],
                        (float) $transactionRow['amount']
                    ),
                    'description' => $transactionRow['description'],
                    'receipt_path' => $transactionRow['receipt_path'],
                    'transaction_date' => $transactionRow['transaction_date'],
                    'created_at' => $transactionRow['created_at'],
                    'created_by' => $transactionRow['created_by'] !== null ? (int) $transactionRow['created_by'] : null,
                    'created_by_name' => $transactionRow['created_by_name']
                ],
                'summary' => [
                    'project_id' => $projectId,
                    'project_name' => $project['name'],
                    'original_budget' => round($originalBudget, 2),
                    'adjustment_increase_total' => round($adjustmentIncreaseTotal, 2),
                    'adjustment_decrease_total' => round($adjustmentDecreaseTotal, 2),
                    'approved_budget' => round($approvedBudget, 2),
                    'expense_total' => round($expenseTotal, 2),
                    'refund_total' => round($refundTotal, 2),
                    'remaining_budget' => round($remainingBudget, 2)
                ]
            ]
        ];
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        return [
            'success' => false,
            'error' => 'Failed to create budget transaction.'
        ];
    }
}

function getProjectBudgetSummary(int $projectId): ?array
{
    $pdo = getDbConnection();

    $projectStmt = $pdo->prepare("
        SELECT
            project_id,
            name
        FROM Projects
        WHERE project_id = :project_id
        LIMIT 1
    ");
    $projectStmt->execute([
        'project_id' => $projectId
    ]);

    $project = $projectStmt->fetch(PDO::FETCH_ASSOC);

    if (!$project) {
        return null;
    }

    $summaryStmt = $pdo->prepare("
        SELECT
            COUNT(*) AS total_transactions,
            COALESCE(SUM(CASE WHEN transaction_type = 'allocation' THEN amount ELSE 0 END), 0) AS original_budget,
            COALESCE(SUM(CASE WHEN transaction_type = 'adjustment_increase' THEN amount ELSE 0 END), 0) AS adjustment_increase_total,
            COALESCE(SUM(CASE WHEN transaction_type = 'adjustment_decrease' THEN amount ELSE 0 END), 0) AS adjustment_decrease_total,
            COALESCE(SUM(CASE WHEN transaction_type = 'expense' THEN amount ELSE 0 END), 0) AS expense_total,
            COALESCE(SUM(CASE WHEN transaction_type = 'refund' THEN amount ELSE 0 END), 0) AS refund_total
        FROM Project_Budget_Transactions
        WHERE project_id = :project_id
    ");
    $summaryStmt->execute([
        'project_id' => $projectId
    ]);

    $row = $summaryStmt->fetch(PDO::FETCH_ASSOC);

    $originalBudget = (float) ($row['original_budget'] ?? 0);
    $adjustmentIncreaseTotal = (float) ($row['adjustment_increase_total'] ?? 0);
    $adjustmentDecreaseTotal = (float) ($row['adjustment_decrease_total'] ?? 0);
    $expenseTotal = (float) ($row['expense_total'] ?? 0);
    $refundTotal = (float) ($row['refund_total'] ?? 0);

    $approvedBudget = $originalBudget + $adjustmentIncreaseTotal - $adjustmentDecreaseTotal;
    $netSpent = $expenseTotal - $refundTotal;
    $remainingBudget = $approvedBudget - $netSpent;

    $spentPercentageOfApprovedBudget = $approvedBudget > 0
        ? round(($netSpent / $approvedBudget) * 100, 2)
        : 0.0;

    return [
        'project_id' => (int) $project['project_id'],
        'project_name' => $project['name'],
        'total_transactions' => (int) ($row['total_transactions'] ?? 0),
        'original_budget' => round($originalBudget, 2),
        'adjustment_increase_total' => round($adjustmentIncreaseTotal, 2),
        'adjustment_decrease_total' => round($adjustmentDecreaseTotal, 2),
        'approved_budget' => round($approvedBudget, 2),
        'expense_total' => round($expenseTotal, 2),
        'refund_total' => round($refundTotal, 2),
        'net_spent' => round($netSpent, 2),
        'remaining_budget' => round($remainingBudget, 2),
        'spent_percentage_of_approved_budget' => $spentPercentageOfApprovedBudget,
        'is_over_budget' => $remainingBudget < 0
    ];
}

function getProjectBudgetTransactions(int $projectId): ?array
{
    $pdo = getDbConnection();

    $summary = getProjectBudgetSummary($projectId);

    if ($summary === null) {
        return null;
    }

    $stmt = $pdo->prepare("
        SELECT
            pbt.transaction_id,
            pbt.project_id,
            pbt.transaction_type,
            pbt.amount,
            pbt.description,
            pbt.receipt_path,
            pbt.transaction_date,
            pbt.created_at,
            pbt.created_by,
            CONCAT(
                COALESCE(e.first_name, ''),
                CASE
                    WHEN e.first_name IS NOT NULL AND e.last_name IS NOT NULL THEN ' '
                    ELSE ''
                END,
                COALESCE(e.last_name, '')
            ) AS created_by_name
        FROM Project_Budget_Transactions pbt
        LEFT JOIN Employees e
            ON e.employee_id = pbt.created_by
        WHERE pbt.project_id = :project_id
        ORDER BY
            pbt.transaction_date ASC,
            pbt.transaction_id ASC
    ");
    $stmt->execute([
        'project_id' => $projectId
    ]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $transactions = [];
    $runningBalance = 0.0;

    foreach ($rows as $row) {
        $amount = (float) $row['amount'];
        $signedAmount = getBudgetTransactionSignedAmount($row['transaction_type'], $amount);
        $runningBalance += $signedAmount;

        $transactions[] = [
            'transaction_id' => (int) $row['transaction_id'],
            'project_id' => (int) $row['project_id'],
            'transaction_type' => $row['transaction_type'],
            'amount' => round($amount, 2),
            'signed_amount' => round($signedAmount, 2),
            'description' => $row['description'],
            'receipt_path' => $row['receipt_path'],
            'transaction_date' => $row['transaction_date'],
            'created_at' => $row['created_at'],
            'created_by' => $row['created_by'] !== null ? (int) $row['created_by'] : null,
            'created_by_name' => $row['created_by_name'],
            'running_balance' => round($runningBalance, 2)
        ];
    }

    return [
        'project_id' => $summary['project_id'],
        'project_name' => $summary['project_name'],
        'summary' => $summary,
        'total_transactions' => count($transactions),
        'transactions' => $transactions
    ];
}