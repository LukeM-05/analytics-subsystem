<?php

require_once __DIR__ . '/../functions/employee_functions.php';
require_once __DIR__ . '/../Text-Chat-Page/functions-text-chat/text-chat-functions.php';
require_once __DIR__ . '/../config/db_config.php';

header('Content-Type: application/json');
session_start();

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

    $email = isset($input['email']) ? trim((string) $input['email']) : '';
    $password = isset($input['password']) ? (string) $input['password'] : '';

    if ($email === '' || $password === '') {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'email and password are required.'
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Invalid email format.'
        ]);
        exit;
    }

    $employeeId = authenticateEmployeeByEmailAndPassword($email, $password);

    if ($employeeId === null) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'error' => 'Invalid email or password.'
        ]);
        exit;
    }

    $_SESSION['user_id'] = $employeeId;

    $roleType = getEmployeeRoleType($employeeId);
    $_SESSION['role_type'] = $roleType;

    $pdo = getDbConnection();
    updateUserStatus($pdo, $employeeId, 'online');

    echo json_encode([
        'success' => true,
        'data' => [
            'employee_id' => $employeeId
        ]
    ]);
} catch (Throwable $e) {
    error_log('Login error: ' . $e->getMessage());
    error_log($e->getTraceAsString());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Internal server error.'
    ]);
}