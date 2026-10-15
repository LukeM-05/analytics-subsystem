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

    $teamleaderId = null;
    if (isset($_GET['teamleader_id']) && $_GET['teamleader_id'] !== '') {
        if (!ctype_digit((string) $_GET['teamleader_id'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'teamleader_id must be a positive integer when provided.'
            ]);
            exit;
        }

        $teamleaderId = (int) $_GET['teamleader_id'];
    }

    $projects = getComparisonProjects($employeeId, $teamleaderId);
    $teamLeadersById = [];

    foreach ($projects as $project) {
        if (!empty($project['teamleader_id'])) {
            $id = (int) $project['teamleader_id'];
            $teamLeadersById[$id] = [
                'employee_id' => $id,
                'name' => $project['teamleader_name'] ?: 'Unknown Team Leader'
            ];
        }
    }

    uasort($teamLeadersById, function (array $a, array $b): int {
        return strcmp($a['name'], $b['name']);
    });

    echo json_encode([
        'success' => true,
        'data' => [
            'employee_id' => $employeeId,
            'teamleader_id' => $teamleaderId,
            'total_projects' => count($projects),
            'projects' => $projects,
            'team_leaders' => array_values($teamLeadersById)
        ]
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Internal server error.'
    ]);
}
