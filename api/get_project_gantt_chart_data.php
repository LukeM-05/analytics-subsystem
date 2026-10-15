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

    if (!isset($_GET['project_id']) || !ctype_digit((string) $_GET['project_id'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'project_id must be provided as a positive integer.'
        ]);
        exit;
    }

    $projectId = (int) $_GET['project_id'];

    $employeeId = null;
    if (isset($_GET['employee_id']) && $_GET['employee_id'] !== '') {
        if (!ctype_digit((string) $_GET['employee_id'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'employee_id must be a positive integer when provided.'
            ]);
            exit;
        }

        $employeeId = (int) $_GET['employee_id'];
    }

    $data = getProjectGanttChartData($projectId, $employeeId);

    if ($data === null) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'error' => 'Project not found.'
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