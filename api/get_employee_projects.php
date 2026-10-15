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

    $employeeId = (int) $_GET['employee_id'];

    $projects = getEmployeeProjects($employeeId);

    echo json_encode([
        'success' => true,
        'data' => [
            'employee_id' => $employeeId,
            'total_projects' => count($projects),
            'projects' => $projects
        ]
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Internal server error.'
    ]);
}