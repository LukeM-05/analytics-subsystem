<?php

require_once __DIR__ . '/../config/db_config.php';

//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------

// returns the role of the employee, or null if not found for login purposes mostly 
function getEmployeeRoleType(int $employeeId): ?string
{
    $pdo = getDbConnection();

    $sql = "SELECT role_type
            FROM Employees
            WHERE employee_id = :employee_id
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'employee_id' => $employeeId
    ]);

    $result = $stmt->fetchColumn();

    return $result === false ? null : $result;
}

//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------

// Possibly for employee cards on manager dashboard
function getEmployeeById(int $employeeId): ?array
{
    $pdo = getDbConnection();

    $sql = "SELECT employee_id, first_name, last_name, role_type
            FROM Employees
            WHERE employee_id = :employee_id
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'employee_id' => $employeeId
    ]);

    $row = $stmt->fetch();

    return $row ?: null;
}

//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------

// returns employee_id if authentication is successful, or null if failed for login page 
function authenticateEmployeeByEmailAndPassword(string $email, string $password): ?int
{
    $email = trim($email);

    if ($email === '' || $password === '') {
        return null;
    }

    $pdo = getDbConnection();

    $sql = "SELECT employee_id, `password`
            FROM Employees
            WHERE email = :email
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'email' => $email
    ]);

    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employee) {
        return null;
    }

    $storedPassword = $employee['password'] ?? '';

    if (!is_string($storedPassword) || $storedPassword === '') {
        return null;
    }

    if ($password !== $storedPassword) {
        return null;
    }

    return (int) $employee['employee_id'];
}

//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------

// returns null if no tasks found or if project dates are invalid, otherwise returns an array with progress variance data
function getEmployeeProjectProgressVariance(int $employeeId, int $projectId): ?array
{
    $pdo = getDbConnection();

    $taskSql = "
        SELECT
            SUM(
                CASE estimated_effort
                    WHEN 'XS' THEN 1
                    WHEN 'S'  THEN 4
                    WHEN 'M'  THEN 8
                    WHEN 'L'  THEN 24
                    WHEN 'XL' THEN 40
                    ELSE 0
                END
            ) AS total_effort_hours,

            SUM(
                CASE
                    WHEN completed_date IS NOT NULL THEN
                        CASE estimated_effort
                            WHEN 'XS' THEN 1
                            WHEN 'S'  THEN 4
                            WHEN 'M'  THEN 8
                            WHEN 'L'  THEN 24
                            WHEN 'XL' THEN 40
                            ELSE 0
                        END
                    ELSE 0
                END
            ) AS completed_effort_hours
        FROM Tasks
        WHERE assignee_id = :employee_id
          AND project_id = :project_id
          AND task_type = 'project'
    ";

    $taskStmt = $pdo->prepare($taskSql);
    $taskStmt->execute([
        'employee_id' => $employeeId,
        'project_id' => $projectId
    ]);

    $taskData = $taskStmt->fetch(PDO::FETCH_ASSOC);

    if (!$taskData) {
        return null;
    }

    $totalEffortHours = (float) ($taskData['total_effort_hours'] ?? 0);
    $completedEffortHours = (float) ($taskData['completed_effort_hours'] ?? 0);

    if ($totalEffortHours <= 0) {
        return null;
    }

    $projectSql = "
        SELECT start_date, due_date
        FROM Projects
        WHERE project_id = :project_id
        LIMIT 1
    ";

    $projectStmt = $pdo->prepare($projectSql);
    $projectStmt->execute([
        'project_id' => $projectId
    ]);

    $projectData = $projectStmt->fetch(PDO::FETCH_ASSOC);

    if (
        !$projectData ||
        empty($projectData['start_date']) ||
        empty($projectData['due_date'])
    ) {
        return null;
    }

    $startDate = new DateTimeImmutable($projectData['start_date']);
    $dueDate = new DateTimeImmutable($projectData['due_date']);
    $now = new DateTimeImmutable('now');

    $startTimestamp = $startDate->getTimestamp();
    $dueTimestamp = $dueDate->getTimestamp();
    $nowTimestamp = $now->getTimestamp();

    $totalProjectSeconds = $dueTimestamp - $startTimestamp;

    if ($totalProjectSeconds <= 0) {
        return null;
    }

    $elapsedSeconds = $nowTimestamp - $startTimestamp;

    if ($elapsedSeconds < 0) {
        $elapsedSeconds = 0;
    }

    if ($elapsedSeconds > $totalProjectSeconds) {
        $elapsedSeconds = $totalProjectSeconds;
    }

    $completedEffortRatio = $completedEffortHours / $totalEffortHours;
    $elapsedTimeRatio = $elapsedSeconds / $totalProjectSeconds;

    $result = ($completedEffortRatio - $elapsedTimeRatio)*100;

    return [
        'employee_id' => $employeeId,
        'project_id' => $projectId,
        'completed_effort_hours' => $completedEffortHours,
        'total_effort_hours' => $totalEffortHours,
        'completed_effort_ratio' => round($completedEffortRatio, 4),
        'elapsed_time_ratio' => round($elapsedTimeRatio, 4),
        'result' => round($result, 4)
    ];
}

//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------

// returns null if project not found, otherwise returns an array with project details
function getProjectDetails(int $projectId): ?array
{
    $pdo = getDbConnection();

    $sql = "
        SELECT
            project_id,
            name,
            status,
            start_date,
            due_date,
            summary,
            milestone,
            risk_level,
            risk_desc,
            teamleader_id,
            visibility,
            created_by,
            conversation_id
        FROM Projects
        WHERE project_id = :project_id
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'project_id' => $projectId
    ]);

    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    return $project ?: null;
}

//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------


// returns an array of tasks for the given project, or an empty array if no tasks found
function getAllTasksByProject(int $projectId): array
{
    $pdo = getDbConnection();

    $sql = "
        SELECT
            t.task_id,
            t.project_id,
            t.assigner_id,
            t.assignee_id,

            CONCAT(
                COALESCE(assigner.first_name, ''),
                CASE
                    WHEN assigner.first_name IS NOT NULL AND assigner.last_name IS NOT NULL THEN ' '
                    ELSE ''
                END,
                COALESCE(assigner.last_name, '')
            ) AS assigner_name,

            CONCAT(
                COALESCE(assignee.first_name, ''),
                CASE
                    WHEN assignee.first_name IS NOT NULL AND assignee.last_name IS NOT NULL THEN ' '
                    ELSE ''
                END,
                COALESCE(assignee.last_name, '')
            ) AS assignee_name,

            t.title,
            t.description,
            t.status,
            t.created_date,
            t.due_date,
            t.priority,
            t.estimated_effort,
            t.task_type,
            t.started_date,
            t.submitted_date,
            t.completed_date,
            t.completion_wait_time,
            t.completed_by_id,
            t.visibility
        FROM Tasks t
        LEFT JOIN Employees assigner
            ON assigner.employee_id = t.assigner_id
        LEFT JOIN Employees assignee
            ON assignee.employee_id = t.assignee_id
        WHERE t.project_id = :project_id
        ORDER BY
            CASE WHEN t.due_date IS NULL THEN 1 ELSE 0 END,
            t.due_date ASC,
            t.created_date ASC,
            t.task_id ASC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'project_id' => $projectId
    ]);

    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $tasks ?: [];
}

//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------


// returns an array of employees assigned to the given project, or an empty array if no employees found
function getAllEmployeesByProject(int $projectId): array
{
    $pdo = getDbConnection();

    $sql = "
        SELECT DISTINCT
            e.employee_id,
            e.first_name,
            e.last_name,
            CONCAT(
                COALESCE(e.first_name, ''),
                CASE
                    WHEN e.first_name IS NOT NULL AND e.last_name IS NOT NULL THEN ' '
                    ELSE ''
                END,
                COALESCE(e.last_name, '')
            ) AS full_name,
            e.email,
            e.role_type,
            e.job_title,
            e.manager_id,
            e.status,
            e.last_login,
            e.created_at,
            e.visibility,
            CASE
                WHEN p.teamleader_id = e.employee_id THEN 1
                ELSE 0
            END AS is_teamleader
        FROM Project_Assignment pa
        INNER JOIN Employees e
            ON e.employee_id = pa.employee_id
        LEFT JOIN Projects p
            ON p.project_id = pa.project_id
        WHERE pa.project_id = :project_id
        ORDER BY
            is_teamleader DESC,
            e.first_name ASC,
            e.last_name ASC,
            e.employee_id ASC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'project_id' => $projectId
    ]);

    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $employees ?: [];
}

//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------


// returns an array of tasks assigned to the given employee, or an empty array if no tasks found
function getAllTasksByEmployee(int $employeeId): array
{
    $pdo = getDbConnection();

    $sql = "
        SELECT
            t.task_id,
            t.project_id,
            p.name AS project_name,
            t.assigner_id,
            t.assignee_id,

            CONCAT(
                COALESCE(assigner.first_name, ''),
                CASE
                    WHEN assigner.first_name IS NOT NULL AND assigner.last_name IS NOT NULL THEN ' '
                    ELSE ''
                END,
                COALESCE(assigner.last_name, '')
            ) AS assigner_name,

            t.title,
            t.description,
            t.status,
            t.created_date,
            t.due_date,
            t.priority,
            t.estimated_effort,
            t.task_type,
            t.started_date,
            t.submitted_date,
            t.completed_date,
            t.completion_wait_time,
            t.completed_by_id,

            CONCAT(
                COALESCE(completer.first_name, ''),
                CASE
                    WHEN completer.first_name IS NOT NULL AND completer.last_name IS NOT NULL THEN ' '
                    ELSE ''
                END,
                COALESCE(completer.last_name, '')
            ) AS completed_by_name,

            t.visibility
        FROM Tasks t
        LEFT JOIN Projects p
            ON p.project_id = t.project_id
        LEFT JOIN Employees assigner
            ON assigner.employee_id = t.assigner_id
        LEFT JOIN Employees completer
            ON completer.employee_id = t.completed_by_id
        WHERE t.assignee_id = :employee_id
        ORDER BY
            CASE WHEN t.completed_date IS NULL THEN 0 ELSE 1 END ASC,
            CASE WHEN t.due_date IS NULL THEN 1 ELSE 0 END ASC,
            t.due_date ASC,
            t.created_date ASC,
            t.task_id ASC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'employee_id' => $employeeId
    ]);

    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$tasks) {
        return [];
    }

    $taskIds = array_column($tasks, 'task_id');

    $placeholders = implode(',', array_fill(0, count($taskIds), '?'));

    $dependencySql = "
        SELECT
            td.task_id,
            td.dependency_id,
            dep.title AS dependency_title,
            dep.status AS dependency_status,
            dep.due_date AS dependency_due_date,
            dep.project_id AS dependency_project_id
        FROM Task_dependency td
        INNER JOIN Tasks dep
            ON dep.task_id = td.dependency_id
        WHERE td.task_id IN ($placeholders)
        ORDER BY td.task_id ASC, td.dependency_id ASC
    ";

    $dependencyStmt = $pdo->prepare($dependencySql);
    $dependencyStmt->execute($taskIds);

    $dependencyRows = $dependencyStmt->fetchAll(PDO::FETCH_ASSOC);

    $dependencyMap = [];

    foreach ($dependencyRows as $row) {
        $taskId = (int) $row['task_id'];

        if (!isset($dependencyMap[$taskId])) {
            $dependencyMap[$taskId] = [];
        }

        $dependencyMap[$taskId][] = [
            'dependency_id' => (int) $row['dependency_id'],
            'dependency_title' => $row['dependency_title'],
            'dependency_status' => $row['dependency_status'],
            'dependency_due_date' => $row['dependency_due_date'],
            'dependency_project_id' => $row['dependency_project_id'] !== null
                ? (int) $row['dependency_project_id']
                : null
        ];
    }

    foreach ($tasks as &$task) {
        $currentTaskId = (int) $task['task_id'];
        $task['dependencies'] = $dependencyMap[$currentTaskId] ?? [];
        $task['dependency_count'] = count($task['dependencies']);
    }
    unset($task);

    return $tasks;
}

//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------


// returns an array of projects assigned to the given employee, or an empty array if no projects found
function getEmployeeProjects(int $employeeId): array
{
    $pdo = getDbConnection();

    $sql = "
        SELECT DISTINCT
            p.project_id,
            p.name,
            p.status,
            p.start_date,
            p.due_date,
            p.summary,
            p.milestone,
            p.risk_level,
            p.risk_desc,
            p.teamleader_id,

            CONCAT(
                COALESCE(tl.first_name, ''),
                CASE
                    WHEN tl.first_name IS NOT NULL AND tl.last_name IS NOT NULL THEN ' '
                    ELSE ''
                END,
                COALESCE(tl.last_name, '')
            ) AS teamleader_name,

            p.visibility,
            p.created_by,
            p.conversation_id
        FROM Project_Assignment pa
        INNER JOIN Projects p
            ON p.project_id = pa.project_id
        LEFT JOIN Employees tl
            ON tl.employee_id = p.teamleader_id
        WHERE pa.employee_id = :employee_id
        ORDER BY
            CASE
                WHEN p.status = 'Behind Schedule' THEN 1
                WHEN p.status = 'On Time' THEN 2
                WHEN p.status = 'Ahead of Schedule' THEN 3
                ELSE 4
            END,
            CASE WHEN p.due_date IS NULL THEN 1 ELSE 0 END,
            p.due_date ASC,
            p.start_date ASC,
            p.project_id ASC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'employee_id' => $employeeId
    ]);

    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $projects ?: [];
}


//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------




// returns an array with success status and either data or error message when trying to update a task's status, with workflow rules applied
function updateTaskStatus(int $taskId, string $newStatus, int $changedByEmployeeId): array
{
    $pdo = getDbConnection();

    $newStatus = trim($newStatus);

    $STATUS_NOT_STARTED = 'Not Started';
    $STATUS_IN_PROGRESS = 'In Progress';
    $STATUS_AWAITING_VALIDATION = 'Awaiting Validation';
    $STATUS_COMPLETED = 'Completed';

    if ($taskId <= 0) {
        return [
            'success' => false,
            'error' => 'task_id must be a positive integer.'
        ];
    }

    if ($changedByEmployeeId <= 0) {
        return [
            'success' => false,
            'error' => 'changed_by_employee_id must be a positive integer.'
        ];
    }

    if ($newStatus === '') {
        return [
            'success' => false,
            'error' => 'status is required.'
        ];
    }

    try {
        $pdo->beginTransaction();

        $sql = "
            SELECT
                t.task_id,
                t.project_id,
                t.status,
                t.started_date,
                t.submitted_date,
                t.completed_date,
                t.completed_by_id,
                p.teamleader_id,
                e.role_type AS changed_by_role
            FROM Tasks t
            LEFT JOIN Projects p
                ON p.project_id = t.project_id
            LEFT JOIN Employees e
                ON e.employee_id = :changed_by_employee_id
            WHERE t.task_id = :task_id
            LIMIT 1
            FOR UPDATE
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'task_id' => $taskId,
            'changed_by_employee_id' => $changedByEmployeeId
        ]);

        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$task) {
            $pdo->rollBack();
            return [
                'success' => false,
                'error' => 'Task not found.'
            ];
        }

        $currentStatus = $task['status'];
        $changedByRole = $task['changed_by_role'] ?? null;
        $teamleaderId = isset($task['teamleader_id']) ? (int) $task['teamleader_id'] : null;

        if ($changedByRole === null) {
            $pdo->rollBack();
            return [
                'success' => false,
                'error' => 'Changing employee was not found.'
            ];
        }

        $isManager = ($changedByRole === 'manager');
        $isProjectTeamLeader = ($teamleaderId !== null && $teamleaderId === $changedByEmployeeId);
        $canReviewValidation = $isManager || $isProjectTeamLeader;

        if ($currentStatus === $newStatus) {
            $pdo->commit();
            return [
                'success' => true,
                'data' => [
                    'task_id' => $taskId,
                    'old_status' => $currentStatus,
                    'new_status' => $newStatus,
                    'message' => 'Status was already set to that value.'
                ]
            ];
        }

        if ($currentStatus === $STATUS_COMPLETED && $newStatus !== $STATUS_COMPLETED) {
            $pdo->rollBack();
            return [
                'success' => false,
                'error' => 'Completed tasks cannot be moved back to another status.'
            ];
        }

        if ($newStatus === $STATUS_COMPLETED && $currentStatus !== $STATUS_AWAITING_VALIDATION) {
            $pdo->rollBack();
            return [
                'success' => false,
                'error' => 'A task can only be moved to Completed from Awaiting Validation.'
            ];
        }

        if ($currentStatus === $STATUS_AWAITING_VALIDATION && $newStatus === $STATUS_NOT_STARTED) {
            $pdo->rollBack();
            return [
                'success' => false,
                'error' => 'A task cannot be moved from Awaiting Validation back to Not Started.'
            ];
        }

        if ($currentStatus === $STATUS_AWAITING_VALIDATION && $newStatus === $STATUS_COMPLETED) {
            if (!$canReviewValidation) {
                $pdo->rollBack();
                return [
                    'success' => false,
                    'error' => 'Only a manager or the project team leader can mark a task as Completed from Awaiting Validation.'
                ];
            }

            $updateSql = "
                UPDATE Tasks
                SET
                    status = :status,
                    completed_date = NOW(),
                    completed_by_id = :completed_by_id
                WHERE task_id = :task_id
                LIMIT 1
            ";

            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                'status' => $newStatus,
                'completed_by_id' => $changedByEmployeeId,
                'task_id' => $taskId
            ]);
        } elseif ($currentStatus === $STATUS_AWAITING_VALIDATION && $newStatus === $STATUS_IN_PROGRESS) {
            if (!$canReviewValidation) {
                $pdo->rollBack();
                return [
                    'success' => false,
                    'error' => 'Only a manager or the project team leader can move a task from Awaiting Validation back to In Progress.'
                ];
            }

            $updateSql = "
                UPDATE Tasks
                SET
                    status = :status,
                    completion_wait_time = CASE
                        WHEN submitted_date IS NOT NULL
                            THEN SEC_TO_TIME(TIMESTAMPDIFF(SECOND, submitted_date, NOW()))
                        ELSE completion_wait_time
                    END,
                    submitted_date = NULL
                WHERE task_id = :task_id
                LIMIT 1
            ";

            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                'status' => $newStatus,
                'task_id' => $taskId
            ]);
        } elseif ($currentStatus === $STATUS_NOT_STARTED && $newStatus === $STATUS_IN_PROGRESS) {
            $updateSql = "
                UPDATE Tasks
                SET
                    status = :status,
                    started_date = COALESCE(started_date, NOW())
                WHERE task_id = :task_id
                LIMIT 1
            ";

            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                'status' => $newStatus,
                'task_id' => $taskId
            ]);
        } elseif ($newStatus === $STATUS_AWAITING_VALIDATION) {
            $updateSql = "
                UPDATE Tasks
                SET
                    status = :status,
                    submitted_date = NOW()
                WHERE task_id = :task_id
                LIMIT 1
            ";

            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                'status' => $newStatus,
                'task_id' => $taskId
            ]);
        } else {
            $updateSql = "
                UPDATE Tasks
                SET
                    status = :status
                WHERE task_id = :task_id
                LIMIT 1
            ";

            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                'status' => $newStatus,
                'task_id' => $taskId
            ]);
        }

        $resultSql = "
            SELECT
                task_id,
                status,
                started_date,
                submitted_date,
                completed_date,
                completion_wait_time,
                completed_by_id
            FROM Tasks
            WHERE task_id = :task_id
            LIMIT 1
        ";

        $resultStmt = $pdo->prepare($resultSql);
        $resultStmt->execute([
            'task_id' => $taskId
        ]);

        $updatedTask = $resultStmt->fetch(PDO::FETCH_ASSOC);

        $pdo->commit();

        return [
            'success' => true,
            'data' => [
                'task_id' => $taskId,
                'old_status' => $currentStatus,
                'new_status' => $updatedTask['status'] ?? $newStatus,
                'started_date' => $updatedTask['started_date'] ?? null,
                'submitted_date' => $updatedTask['submitted_date'] ?? null,
                'completed_date' => $updatedTask['completed_date'] ?? null,
                'completion_wait_time' => $updatedTask['completion_wait_time'] ?? null,
                'completed_by_id' => isset($updatedTask['completed_by_id']) && $updatedTask['completed_by_id'] !== null
                    ? (int) $updatedTask['completed_by_id']
                    : null
            ]
        ];
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        return [
            'success' => false,
            'error' => 'Failed to update task status.'
        ];
    }
}



//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------


// helper function to format duration from seconds to HH:MM:SS, returns null if input is null
function formatDurationFromSeconds(?int $seconds): ?string
{
    if ($seconds === null) {
        return null;
    }

    if ($seconds < 0) {
        $seconds = 0;
    }

    $hours = intdiv($seconds, 3600);
    $minutes = intdiv($seconds % 3600, 60);
    $remainingSeconds = $seconds % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $remainingSeconds);
}


// --------------------------------------------------------------
// this function is used in the manager dashboard to show the progress trend of projects, with optional filters for search term, team leader, progress range, and active status
function getProjectEffortEstimationAccuracy(int $projectId, ?int $employeeId = null): ?array
{
    $pdo = getDbConnection();

    $projectSql = "
        SELECT
            project_id,
            name
        FROM Projects
        WHERE project_id = :project_id
        LIMIT 1
    ";

    $projectStmt = $pdo->prepare($projectSql);
    $projectStmt->execute([
        'project_id' => $projectId
    ]);

    $project = $projectStmt->fetch(PDO::FETCH_ASSOC);

    if (!$project) {
        return null;
    }

    $taskSql = "
        SELECT
            t.task_id,
            t.project_id,
            t.assignee_id,
            CONCAT(
                COALESCE(e.first_name, ''),
                CASE
                    WHEN e.first_name IS NOT NULL AND e.last_name IS NOT NULL THEN ' '
                    ELSE ''
                END,
                COALESCE(e.last_name, '')
            ) AS assignee_name,
            t.title,
            t.status,
            t.estimated_effort,
            t.started_date,
            t.submitted_date,
            t.completed_date,
            t.completion_wait_time,
            CASE t.estimated_effort
                WHEN 'XS' THEN 1
                WHEN 'S'  THEN 4
                WHEN 'M'  THEN 8
                WHEN 'L'  THEN 24
                WHEN 'XL' THEN 40
                ELSE 0
            END AS estimated_effort_hours,
            CASE
                WHEN t.started_date IS NOT NULL AND t.completed_date IS NOT NULL THEN
                    GREATEST(
                        0,
                        TIMESTAMPDIFF(SECOND, t.started_date, t.completed_date)
                        - COALESCE(TIME_TO_SEC(t.completion_wait_time), 0)
                    )
                ELSE NULL
            END AS actual_effort_seconds
        FROM Tasks t
        LEFT JOIN Employees e
            ON e.employee_id = t.assignee_id
        WHERE t.project_id = :project_id
          AND t.task_type = 'project'
    ";

    $params = [
        'project_id' => $projectId
    ];

    if ($employeeId !== null) {
        $taskSql .= " AND t.assignee_id = :employee_id ";
        $params['employee_id'] = $employeeId;
    }

    $taskSql .= "
        ORDER BY
            CASE WHEN t.due_date IS NULL THEN 1 ELSE 0 END,
            t.due_date ASC,
            t.created_date ASC,
            t.task_id ASC
    ";

    $taskStmt = $pdo->prepare($taskSql);
    $taskStmt->execute($params);

    $taskRows = $taskStmt->fetchAll(PDO::FETCH_ASSOC);

    $tasks = [];
    $totalEstimatedHours = 0.0;
    $totalActualSeconds = 0;
    $completedTaskCount = 0;

    foreach ($taskRows as $row) {
        $estimatedHours = (float) ($row['estimated_effort_hours'] ?? 0);

        $actualSeconds = $row['actual_effort_seconds'] !== null
            ? (int) $row['actual_effort_seconds']
            : null;

        $actualHours = $actualSeconds !== null
            ? round($actualSeconds / 3600, 2)
            : null;

        $varianceHours = $actualHours !== null
            ? round($actualHours - $estimatedHours, 2)
            : null;

        if ($row['completed_date'] !== null) {
            $completedTaskCount++;
        }

        $totalEstimatedHours += $estimatedHours;

        if ($actualSeconds !== null) {
            $totalActualSeconds += $actualSeconds;
        }

        $tasks[] = [
            'task_id' => (int) $row['task_id'],
            'project_id' => (int) $row['project_id'],
            'assignee_id' => $row['assignee_id'] !== null ? (int) $row['assignee_id'] : null,
            'assignee_name' => $row['assignee_name'],
            'title' => $row['title'],
            'status' => $row['status'],
            'estimated_effort' => $row['estimated_effort'],
            'estimated_effort_hours' => $estimatedHours,
            'started_date' => $row['started_date'],
            'submitted_date' => $row['submitted_date'],
            'completed_date' => $row['completed_date'],
            'completion_wait_time' => $row['completion_wait_time'],
            'actual_effort_seconds' => $actualSeconds,
            'actual_effort_time' => formatDurationFromSeconds($actualSeconds),
            'actual_effort_hours' => $actualHours,
            'variance_hours' => $varianceHours
        ];
    }

    $totalActualHours = round($totalActualSeconds / 3600, 2);
    $projectVarianceHours = round($totalActualHours - $totalEstimatedHours, 2);

    return [
        'project_id' => (int) $project['project_id'],
        'project_name' => $project['name'],
        'employee_id' => $employeeId,
        'total_tasks' => count($tasks),
        'completed_tasks' => $completedTaskCount,
        'total_estimated_effort_hours' => round($totalEstimatedHours, 2),
        'total_actual_effort_seconds' => $totalActualSeconds,
        'total_actual_effort_time' => formatDurationFromSeconds($totalActualSeconds),
        'total_actual_effort_hours' => $totalActualHours,
        'project_variance_hours' => $projectVarianceHours,
        'tasks' => $tasks
    ];
}



//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------


// returns null if project not found, otherwise returns an array with project details and its tasks formatted for Gantt chart display
function getProjectGanttChartData(int $projectId, ?int $employeeId = null): ?array
{
    $pdo = getDbConnection();

    $projectSql = "
        SELECT
            project_id,
            name,
            status,
            start_date,
            due_date,
            summary,
            milestone,
            teamleader_id
        FROM Projects
        WHERE project_id = :project_id
        LIMIT 1
    ";

    $projectStmt = $pdo->prepare($projectSql);
    $projectStmt->execute([
        'project_id' => $projectId
    ]);

    $project = $projectStmt->fetch(PDO::FETCH_ASSOC);

    if (!$project) {
        return null;
    }

    $taskSql = "
        SELECT
            t.task_id,
            t.project_id,
            t.assigner_id,
            t.assignee_id,
            CONCAT(
                COALESCE(assigner.first_name, ''),
                CASE
                    WHEN assigner.first_name IS NOT NULL AND assigner.last_name IS NOT NULL THEN ' '
                    ELSE ''
                END,
                COALESCE(assigner.last_name, '')
            ) AS assigner_name,
            CONCAT(
                COALESCE(assignee.first_name, ''),
                CASE
                    WHEN assignee.first_name IS NOT NULL AND assignee.last_name IS NOT NULL THEN ' '
                    ELSE ''
                END,
                COALESCE(assignee.last_name, '')
            ) AS assignee_name,
            t.title,
            t.description,
            t.status,
            t.created_date,
            t.due_date,
            t.priority,
            t.estimated_effort,
            t.task_type,
            t.started_date,
            t.submitted_date,
            t.completed_date,
            t.completion_wait_time,
            t.completed_by_id,
            t.visibility,
            CASE t.estimated_effort
                WHEN 'XS' THEN 1
                WHEN 'S'  THEN 4
                WHEN 'M'  THEN 8
                WHEN 'L'  THEN 24
                WHEN 'XL' THEN 40
                ELSE 0
            END AS estimated_effort_hours,
            CASE
                WHEN t.started_date IS NOT NULL AND t.completed_date IS NOT NULL THEN
                    GREATEST(
                        0,
                        TIMESTAMPDIFF(SECOND, t.started_date, t.completed_date)
                        - COALESCE(TIME_TO_SEC(t.completion_wait_time), 0)
                    )
                ELSE NULL
            END AS actual_effort_seconds,
            CASE t.status
                WHEN 'Not Started' THEN 0
                WHEN 'In Progress' THEN 50
                WHEN 'Awaiting Validation' THEN 90
                WHEN 'Completed' THEN 100
                ELSE 0
            END AS progress_percentage
        FROM Tasks t
        LEFT JOIN Employees assigner
            ON assigner.employee_id = t.assigner_id
        LEFT JOIN Employees assignee
            ON assignee.employee_id = t.assignee_id
        WHERE t.project_id = :project_id
          AND t.task_type = 'project'
    ";

    $params = [
        'project_id' => $projectId
    ];

    if ($employeeId !== null) {
        $taskSql .= " AND t.assignee_id = :employee_id ";
        $params['employee_id'] = $employeeId;
    }

    $taskSql .= "
        ORDER BY
            CASE WHEN t.started_date IS NULL THEN 1 ELSE 0 END,
            t.started_date ASC,
            CASE WHEN t.due_date IS NULL THEN 1 ELSE 0 END,
            t.due_date ASC,
            t.created_date ASC,
            t.task_id ASC
    ";

    $taskStmt = $pdo->prepare($taskSql);
    $taskStmt->execute($params);

    $taskRows = $taskStmt->fetchAll(PDO::FETCH_ASSOC);

    $tasks = [];

    foreach ($taskRows as $row) {
        $actualSeconds = $row['actual_effort_seconds'] !== null
            ? (int) $row['actual_effort_seconds']
            : null;

        $ganttStartDate = $row['started_date']
            ?? $row['created_date']
            ?? $project['start_date']
            ?? null;

        $ganttEndDate = $row['completed_date']
            ?? $row['due_date']
            ?? $project['due_date']
            ?? null;

        $tasks[(int) $row['task_id']] = [
            'task_id' => (int) $row['task_id'],
            'project_id' => (int) $row['project_id'],
            'assigner_id' => $row['assigner_id'] !== null ? (int) $row['assigner_id'] : null,
            'assignee_id' => $row['assignee_id'] !== null ? (int) $row['assignee_id'] : null,
            'assigner_name' => $row['assigner_name'],
            'assignee_name' => $row['assignee_name'],
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => $row['status'],
            'created_date' => $row['created_date'],
            'due_date' => $row['due_date'],
            'priority' => $row['priority'],
            'estimated_effort' => $row['estimated_effort'],
            'estimated_effort_hours' => (float) $row['estimated_effort_hours'],
            'task_type' => $row['task_type'],
            'started_date' => $row['started_date'],
            'submitted_date' => $row['submitted_date'],
            'completed_date' => $row['completed_date'],
            'completion_wait_time' => $row['completion_wait_time'],
            'completed_by_id' => $row['completed_by_id'] !== null ? (int) $row['completed_by_id'] : null,
            'visibility' => $row['visibility'] !== null ? (int) $row['visibility'] : null,
            'actual_effort_seconds' => $actualSeconds,
            'actual_effort_time' => formatDurationFromSeconds($actualSeconds),
            'actual_effort_hours' => $actualSeconds !== null ? round($actualSeconds / 3600, 2) : null,
            'progress_percentage' => (int) $row['progress_percentage'],
            'gantt_start_date' => $ganttStartDate,
            'gantt_end_date' => $ganttEndDate,
            'dependency_ids' => [],
            'dependencies' => []
        ];
    }

    if (!empty($tasks)) {
        $taskIds = array_keys($tasks);
        $placeholders = implode(',', array_fill(0, count($taskIds), '?'));

        $dependencySql = "
            SELECT
                td.task_id,
                td.dependency_id,
                dep.title AS dependency_title,
                dep.status AS dependency_status
            FROM Task_dependency td
            INNER JOIN Tasks dep
                ON dep.task_id = td.dependency_id
            WHERE td.task_id IN ($placeholders)
            ORDER BY td.task_id ASC, td.dependency_id ASC
        ";

        $dependencyStmt = $pdo->prepare($dependencySql);
        $dependencyStmt->execute($taskIds);

        $dependencyRows = $dependencyStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dependencyRows as $dependencyRow) {
            $taskId = (int) $dependencyRow['task_id'];

            if (!isset($tasks[$taskId])) {
                continue;
            }

            $dependencyId = (int) $dependencyRow['dependency_id'];

            $tasks[$taskId]['dependency_ids'][] = $dependencyId;
            $tasks[$taskId]['dependencies'][] = [
                'dependency_id' => $dependencyId,
                'dependency_title' => $dependencyRow['dependency_title'],
                'dependency_status' => $dependencyRow['dependency_status']
            ];
        }
    }

    return [
        'project' => [
            'project_id' => (int) $project['project_id'],
            'name' => $project['name'],
            'status' => $project['status'],
            'start_date' => $project['start_date'],
            'due_date' => $project['due_date'],
            'summary' => $project['summary'],
            'milestone' => $project['milestone'],
            'teamleader_id' => $project['teamleader_id'] !== null ? (int) $project['teamleader_id'] : null
        ],
        'employee_id' => $employeeId,
        'total_tasks' => count($tasks),
        'tasks' => array_values($tasks)
    ];
}





//--------------------------------------------------------------
//---------------------New Function-----------------------------
//--------------------------------------------------------------



// returns an array of projects with progress percentage for a given manager, with optional filters for search term, team leader, progress range, and active status
function getManagerProjectProgressTrend(
    ?string $search = null,
    ?int $teamleaderId = null,
    ?float $minProgress = null,
    ?float $maxProgress = null,
    bool $activeOnly = true
): array {
    $pdo = getDbConnection();

    $sql = "
        SELECT
            p.project_id,
            p.name,
            p.status,
            p.start_date,
            p.due_date,
            p.summary,
            p.milestone,
            p.risk_level,
            p.risk_desc,
            p.teamleader_id,
            CONCAT(
                COALESCE(tl.first_name, ''),
                CASE
                    WHEN tl.first_name IS NOT NULL AND tl.last_name IS NOT NULL THEN ' '
                    ELSE ''
                END,
                COALESCE(tl.last_name, '')
            ) AS teamleader_name,
            COUNT(t.task_id) AS total_tasks,
            SUM(
                CASE
                    WHEN t.completed_date IS NOT NULL THEN 1
                    ELSE 0
                END
            ) AS completed_tasks,
            COALESCE(
                SUM(
                    CASE t.estimated_effort
                        WHEN 'XS' THEN 1
                        WHEN 'S'  THEN 4
                        WHEN 'M'  THEN 8
                        WHEN 'L'  THEN 24
                        WHEN 'XL' THEN 40
                        ELSE 0
                    END
                ),
                0
            ) AS total_estimated_effort_hours,
            COALESCE(
                SUM(
                    CASE
                        WHEN t.completed_date IS NOT NULL THEN
                            CASE t.estimated_effort
                                WHEN 'XS' THEN 1
                                WHEN 'S'  THEN 4
                                WHEN 'M'  THEN 8
                                WHEN 'L'  THEN 24
                                WHEN 'XL' THEN 40
                                ELSE 0
                            END
                        ELSE 0
                    END
                ),
                0
            ) AS completed_estimated_effort_hours
        FROM Projects p
        LEFT JOIN Employees tl
            ON tl.employee_id = p.teamleader_id
        LEFT JOIN Tasks t
            ON t.project_id = p.project_id
           AND t.task_type = 'project'
        WHERE 1 = 1
    ";

    $params = [];

    $search = $search !== null ? trim($search) : null;
    if ($search !== null && $search !== '') {
        $sql .= " AND (p.name LIKE :search OR p.summary LIKE :search) ";
        $params['search'] = '%' . $search . '%';
    }

    if ($teamleaderId !== null) {
        $sql .= " AND p.teamleader_id = :teamleader_id ";
        $params['teamleader_id'] = $teamleaderId;
    }

    $sql .= "
        GROUP BY
            p.project_id,
            p.name,
            p.status,
            p.start_date,
            p.due_date,
            p.summary,
            p.milestone,
            p.risk_level,
            p.risk_desc,
            p.teamleader_id,
            tl.first_name,
            tl.last_name
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $projects = [];

    foreach ($rows as $row) {
        $totalTasks = (int) ($row['total_tasks'] ?? 0);
        $completedTasks = (int) ($row['completed_tasks'] ?? 0);
        $totalEstimatedEffortHours = (float) ($row['total_estimated_effort_hours'] ?? 0);
        $completedEstimatedEffortHours = (float) ($row['completed_estimated_effort_hours'] ?? 0);

        if ($totalEstimatedEffortHours > 0) {
            $progressRatio = $completedEstimatedEffortHours / $totalEstimatedEffortHours;
        } elseif ($totalTasks > 0) {
            $progressRatio = $completedTasks / $totalTasks;
        } else {
            $progressRatio = 0.0;
        }

        $progressPercentage = round($progressRatio * 100, 2);

        if ($activeOnly && $progressPercentage >= 100) {
            continue;
        }

        if ($minProgress !== null && $progressPercentage < $minProgress) {
            continue;
        }

        if ($maxProgress !== null && $progressPercentage > $maxProgress) {
            continue;
        }

        $projects[] = [
            'project_id' => (int) $row['project_id'],
            'name' => $row['name'],
            'status' => $row['status'],
            'start_date' => $row['start_date'],
            'due_date' => $row['due_date'],
            'summary' => $row['summary'],
            'milestone' => $row['milestone'],
            'risk_level' => $row['risk_level'],
            'risk_desc' => $row['risk_desc'],
            'teamleader_id' => $row['teamleader_id'] !== null ? (int) $row['teamleader_id'] : null,
            'teamleader_name' => $row['teamleader_name'],
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'total_estimated_effort_hours' => $totalEstimatedEffortHours,
            'completed_estimated_effort_hours' => $completedEstimatedEffortHours,
            'team_progress_ratio' => round($progressRatio, 4),
            'team_progress_percentage' => $progressPercentage,
            'is_active' => $progressPercentage < 100
        ];
    }

    usort($projects, function (array $a, array $b): int {
        if ($a['team_progress_percentage'] !== $b['team_progress_percentage']) {
            return $a['team_progress_percentage'] <=> $b['team_progress_percentage'];
        }

        $aDue = $a['due_date'] ?? '9999-12-31 23:59:59';
        $bDue = $b['due_date'] ?? '9999-12-31 23:59:59';

        if ($aDue !== $bDue) {
            return strcmp($aDue, $bDue);
        }

        return strcmp($a['name'], $b['name']);
    });

    $chartData = [];
    foreach ($projects as $project) {
        $chartData[] = [
            'project_id' => $project['project_id'],
            'label' => $project['name'],
            'teamleader_id' => $project['teamleader_id'],
            'teamleader_name' => $project['teamleader_name'],
            'value' => $project['team_progress_percentage']
        ];
    }

    return [
        'filters' => [
            'search' => $search,
            'teamleader_id' => $teamleaderId,
            'min_progress' => $minProgress,
            'max_progress' => $maxProgress,
            'active_only' => $activeOnly
        ],
        'total_projects' => count($projects),
        'projects' => $projects,
        'chart_data' => $chartData
    ];
}