<?php

require_once __DIR__ . '/../functions/budget_functions.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'error' => 'Method not allowed. Use POST.'
        ]);
        exit;
    }

    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    $input = [];

    if (stripos($contentType, 'application/json') !== false) {
        $rawBody = file_get_contents('php://input');
        $decoded = json_decode($rawBody, true);

        if (is_array($decoded)) {
            $input = $decoded;
        }
    } else {
        $input = $_POST;
    }

    $projectId = isset($input['project_id']) ? (int) $input['project_id'] : 0;
    $transactionType = isset($input['transaction_type']) ? (string) $input['transaction_type'] : '';
    $amount = isset($input['amount']) && is_numeric($input['amount']) ? (float) $input['amount'] : 0;
    $transactionDate = isset($input['transaction_date']) ? (string) $input['transaction_date'] : '';
    $description = isset($input['description']) ? (string) $input['description'] : null;
    $receiptPath = isset($input['receipt_path']) ? (string) $input['receipt_path'] : null;
    $createdBy = isset($input['created_by']) && $input['created_by'] !== ''
        ? (int) $input['created_by']
        : null;

    if ($projectId <= 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'project_id must be provided as a positive integer.'
        ]);
        exit;
    }

    if ($transactionType === '') {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'transaction_type is required.'
        ]);
        exit;
    }

    if ($amount <= 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'amount must be greater than 0.'
        ]);
        exit;
    }

    if ($transactionDate === '') {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'transaction_date is required.'
        ]);
        exit;
    }

    $result = createProjectBudgetTransaction(
        $projectId,
        $transactionType,
        $amount,
        $transactionDate,
        $description,
        $receiptPath,
        $createdBy
    );

    if (!$result['success']) {
        $error = $result['error'] ?? 'Failed to create budget transaction.';
        $statusCode = 400;

        if ($error === 'Project not found.' || $error === 'created_by employee was not found.') {
            $statusCode = 404;
        }

        http_response_code($statusCode);
        echo json_encode($result);
        exit;
    }

    echo json_encode($result);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Internal server error.'
    ]);
}