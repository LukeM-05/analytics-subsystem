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

    $search = isset($_GET['search']) ? trim((string) $_GET['search']) : null;

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

    $minProgress = null;
    if (isset($_GET['min_progress']) && $_GET['min_progress'] !== '') {
        if (!is_numeric($_GET['min_progress'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'min_progress must be numeric when provided.'
            ]);
            exit;
        }
        $minProgress = (float) $_GET['min_progress'];
    }

    $maxProgress = null;
    if (isset($_GET['max_progress']) && $_GET['max_progress'] !== '') {
        if (!is_numeric($_GET['max_progress'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'max_progress must be numeric when provided.'
            ]);
            exit;
        }
        $maxProgress = (float) $_GET['max_progress'];
    }

    $activeOnly = true;
    if (isset($_GET['active_only']) && $_GET['active_only'] !== '') {
        $activeOnly = $_GET['active_only'] === '1';
    }

    $data = getManagerProjectProgressTrend(
        $search,
        $teamleaderId,
        $minProgress,
        $maxProgress,
        $activeOnly
    );

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