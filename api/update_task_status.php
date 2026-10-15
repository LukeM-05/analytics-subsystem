<?php

require_once __DIR__ . '/../functions/employee_functions.php';

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

    $taskId = isset($input['task_id']) ? (int) $input['task_id'] : 0;
    $newStatus = isset($input['status']) ? trim((string) $input['status']) : '';
    $changedByEmployeeId = isset($input['changed_by_employee_id']) ? (int) $input['changed_by_employee_id'] : 0;

    if ($taskId <= 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'task_id must be provided as a positive integer.'
        ]);
        exit;
    }

    if ($newStatus === '') {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'status is required.'
        ]);
        exit;
    }

    if ($changedByEmployeeId <= 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'changed_by_employee_id must be provided as a positive integer.'
        ]);
        exit;
    }

    $result = updateTaskStatus($taskId, $newStatus, $changedByEmployeeId);

    if (!$result['success']) {
        $error = $result['error'] ?? 'Failed to update task status.';

        $statusCode = 400;

        if ($error === 'Task not found.' || $error === 'Changing employee was not found.') {
            $statusCode = 404;
        } elseif (
            str_contains($error, 'Only a manager') ||
            str_contains($error, 'cannot be moved') ||
            str_contains($error, 'can only be moved')
        ) {
            $statusCode = 403;
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