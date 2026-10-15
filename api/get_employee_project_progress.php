<?php

require_once __DIR__ . '/../functions/employee_functions.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'error' => 'Method not allowed. Use GET.'
        ]);
        exit;
    }

    if (!isset($_GET['employee_id']) || !ctype_digit((string) $_GET['employee_id'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'employee_id must be provided as a positive integer.'
        ]);
        exit;
    }

    if (!isset($_GET['project_id']) || !ctype_digit((string) $_GET['project_id'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'project_id must be provided as a positive integer.'
        ]);
        exit;
    }

    $employeeId = (int) $_GET['employee_id'];
    $projectId = (int) $_GET['project_id'];

    $data = getEmployeeProjectProgressVariance($employeeId, $projectId);

    if ($data === null) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'error' => 'No matching project task data found, or the project dates are invalid.'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Internal server error.'
    ]);
}