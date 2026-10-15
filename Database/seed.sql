
SET FOREIGN_KEY_CHECKS = 0;


INSERT INTO Employees (employee_id, first_name, last_name, email, role_type, job_title, profile_picture, manager_id, status, last_login, created_at, password, visibility) VALUES
(1, 'Sarah', 'Connor', 's.connor@makeitall.com', 'manager', 'Head of IT', NULL, NULL, 'online', NOW(), DATE_SUB(NOW(), INTERVAL 1 YEAR), 'hash1', 1),
(2, 'Marcus', 'Wright', 'm.wright@makeitall.com', 'teamLeader', 'Lead Backend Eng', NULL, 1, 'busy', NOW(), DATE_SUB(NOW(), INTERVAL 11 MONTH), 'hash2', 1),
(3, 'Kyle', 'Reese', 'k.reese@makeitall.com', 'teamLeader', 'Lead Frontend Eng', NULL, 1, 'offline', DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 10 MONTH), 'hash3', 1),
(4, 'John', 'Smith', 'j.smith@makeitall.com', 'employee', 'Backend Developer', NULL, 2, 'online', NOW(), DATE_SUB(NOW(), INTERVAL 6 MONTH), 'hash4', 1),
(5, 'Kate', 'Brewster', 'k.brewster@makeitall.com', 'employee', 'Frontend Developer', NULL, 3, 'busy', NOW(), DATE_SUB(NOW(), INTERVAL 5 MONTH), 'hash5', 1),
(6, 'Miles', 'Dyson', 'm.dyson@makeitall.com', 'employee', 'Database Admin', NULL, 2, 'offline', DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 YEAR), 'hash6', 1);


INSERT INTO Categories (category_id, categories) VALUES
(1, 'backend dev'), (2, 'frontend dev'), (3, 'management'), (4, 'SQL'), (5, 'web dev');


INSERT INTO Conversations (conversation_id, type, title, creator_id, created_at, last_message_id, visibility) VALUES
(1, 'GC', 'Backend Team Sync', 2, DATE_SUB(NOW(), INTERVAL 30 DAY), NULL, 1),
(2, 'GC', 'Frontend Revamp Alpha', 3, DATE_SUB(NOW(), INTERVAL 20 DAY), NULL, 1),
(3, 'DM', 'Sarah & Marcus 1:1', 1, DATE_SUB(NOW(), INTERVAL 60 DAY), NULL, 1),
(4, 'GC', 'Emergency Server Migration', 1, DATE_SUB(NOW(), INTERVAL 5 DAY), NULL, 1),
(5, 'DM', 'John & Kate Chatter', 4, DATE_SUB(NOW(), INTERVAL 10 DAY), NULL, 1);


INSERT INTO Projects (project_id, name, status, start_date, due_date, summary, milestone, risk_level, risk_desc, teamleader_id, visibility, created_by, conversation_id) VALUES
(1, 'API Gateway V2', 'On Time', DATE_SUB(NOW(), INTERVAL 30 DAY), DATE_ADD(NOW(), INTERVAL 60 DAY), 'Rewrite the core API gateway', 'Architecture Approved', 'Low', 'None', 2, 1, 1, 1),
(2, 'React Dashboard Migration', 'Behind Schedule', DATE_SUB(NOW(), INTERVAL 45 DAY), DATE_ADD(NOW(), INTERVAL 5 DAY), 'Move from Angular to React', 'UI Components', 'High', 'Understaffed', 3, 1, 1, 2),
(3, 'Legacy DB Sunset', 'At Risk', DATE_SUB(NOW(), INTERVAL 90 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY), 'Decommission old SQL servers', 'Data Migration Overdue', 'Urgent', 'Data loss risk', 2, 1, 1, 4),
(4, 'Q3 Roadmap Planning', 'On Time', DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_ADD(NOW(), INTERVAL 20 DAY), 'Plan Q3 deliverables', 'Draft 1', 'Low', '', 1, 1, 1, NULL),
(5, 'Auth0 Integration', 'Ahead of Schedule', DATE_SUB(NOW(), INTERVAL 15 DAY), DATE_ADD(NOW(), INTERVAL 30 DAY), 'Implement SSO', 'Testing', 'Medium', 'Third party API limits', 3, 1, 2, NULL);


INSERT INTO Project_Assignment (project_id, employee_id) VALUES
(1, 2), (1, 4), (2, 3), (2, 5), (3, 2), (3, 6), (4, 1), (4, 2), (4, 3), (5, 3), (5, 4);

INSERT INTO Category_Assignment (assignment_id, category_id, project_id, employee_id) VALUES
(1, 1, 1, 4), (2, 2, 2, 5), (3, 4, 3, 6), (4, 3, 4, 1), (5, 5, 5, 4);


INSERT INTO Tasks (task_id, project_id, assigner_id, assignee_id, title, description, status, created_date, due_date, priority, estimated_effort, task_type, started_date, submitted_date, completed_date, completion_wait_time, completed_by_id, visibility) VALUES
-- On Time / Completed
(1, 1, 2, 4, 'Setup Node Express boilerplate', 'Basic routing setup', 'Completed', DATE_SUB(NOW(), INTERVAL 25 DAY), DATE_SUB(NOW(), INTERVAL 20 DAY), 'Medium', 'S', 'project', DATE_SUB(NOW(), INTERVAL 24 DAY), DATE_SUB(NOW(), INTERVAL 21 DAY), DATE_SUB(NOW(), INTERVAL 21 DAY), '02:00:00', 2, 1),
(2, 5, 3, 4, 'Generate API Keys', 'Get Auth0 keys', 'Completed', DATE_SUB(NOW(), INTERVAL 14 DAY), DATE_SUB(NOW(), INTERVAL 10 DAY), 'High', 'XS', 'project', DATE_SUB(NOW(), INTERVAL 13 DAY), DATE_SUB(NOW(), INTERVAL 12 DAY), DATE_SUB(NOW(), INTERVAL 12 DAY), '01:30:00', 3, 1),

-- In Progress (Normal)
(3, 1, 2, 4, 'Write JWT Middleware', 'Token validation', 'In Progress', DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_ADD(NOW(), INTERVAL 5 DAY), 'High', 'M', 'project', DATE_SUB(NOW(), INTERVAL 2 DAY), NULL, NULL, NULL, NULL, 1),
(4, 2, 3, 5, 'Convert Nav Bar', 'React hooks conversion', 'In Progress', DATE_SUB(NOW(), INTERVAL 10 DAY), DATE_ADD(NOW(), INTERVAL 2 DAY), 'Medium', 'M', 'project', DATE_SUB(NOW(), INTERVAL 8 DAY), NULL, NULL, NULL, NULL, 1),

-- SCENARIO: Severely Overdue (Not Started & Past Due)
(5, 3, 2, 6, 'Backup DB Table A', 'Must be done before deletion', 'Not Started', DATE_SUB(NOW(), INTERVAL 15 DAY), DATE_SUB(NOW(), INTERVAL 10 DAY), 'High', 'L', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(6, 3, 2, 6, 'Backup DB Table B', 'Must be done before deletion', 'Not Started', DATE_SUB(NOW(), INTERVAL 15 DAY), DATE_SUB(NOW(), INTERVAL 8 DAY), 'High', 'L', 'project', NULL, NULL, NULL, NULL, NULL, 1),

-- SCENARIO: Overdue (In Progress & Past Due)
(7, 2, 3, 5, 'Migrate User Settings Page', 'Complex state mapping needed', 'In Progress', DATE_SUB(NOW(), INTERVAL 30 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY), 'High', 'XL', 'project', DATE_SUB(NOW(), INTERVAL 28 DAY), NULL, NULL, NULL, NULL, 1),
(8, 3, 2, 2, 'Audit Old Credentials', 'Check for hardcoded passwords', 'In Progress', DATE_SUB(NOW(), INTERVAL 20 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY), 'Medium', 'M', 'project', DATE_SUB(NOW(), INTERVAL 18 DAY), NULL, NULL, NULL, NULL, 1),

-- Awaiting Validation
(9, 1, 2, 4, 'Document API Endpoints', 'Swagger docs', 'Awaiting Validation', DATE_SUB(NOW(), INTERVAL 10 DAY), DATE_ADD(NOW(), INTERVAL 1 DAY), 'Low', 'S', 'project', DATE_SUB(NOW(), INTERVAL 8 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY), NULL, NULL, NULL, 1),

-- Private Task (Overdue)
(10, NULL, 1, 1, 'Submit Expense Report', 'For Q1 conference', 'Not Started', DATE_SUB(NOW(), INTERVAL 14 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY), 'Medium', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1);


INSERT INTO Task_dependency (task_id, dependency_id) VALUES
(6, 5),  -- Backup B depends on Backup A
(9, 3),  -- Docs depend on Middleware
(7, 4);  -- Settings page depends on Nav bar


INSERT INTO Messages (message_id, conversation_id, sender_id, parent_messgae_id, body, created_at, visibility) VALUES
(1, 1, 2, NULL, 'Hey team, API gateway is looking good.', DATE_SUB(NOW(), INTERVAL 10 DAY), 1),
(2, 1, 4, 1, 'I will have the middleware done by Friday.', DATE_SUB(NOW(), INTERVAL 9 DAY), 1),
(3, 2, 3, NULL, 'Kate, how is the User Settings migration going? We are behind schedule.', DATE_SUB(NOW(), INTERVAL 4 DAY), 1),
(4, 2, 5, 3, 'It is tougher than expected. Lots of technical debt.', DATE_SUB(NOW(), INTERVAL 3 DAY), 1),
(5, 4, 1, NULL, 'Marcus, why is the DB Sunset project at risk?', DATE_SUB(NOW(), INTERVAL 2 DAY), 1),
(6, 4, 2, 5, 'Miles is swamped, backups haven\'t started. They are overdue by a week.', DATE_SUB(NOW(), INTERVAL 2 DAY), 1),
(7, 4, 1, 6, 'Please re-allocate resources immediately. This is urgent.', DATE_SUB(NOW(), INTERVAL 1 DAY), 1),
(8, 3, 1, NULL, 'Marcus, let\'s sync on the database issue tomorrow.', DATE_SUB(NOW(), INTERVAL 1 DAY), 1),
(9, 5, 4, NULL, 'Did you get the new Auth0 keys working?', DATE_SUB(NOW(), INTERVAL 1 HOUR), 1),
(10, 5, 5, 9, 'Yes, plugged them in this morning.', NOW(), 1);


UPDATE Conversations SET last_message_id = 2 WHERE conversation_id = 1;
UPDATE Conversations SET last_message_id = 4 WHERE conversation_id = 2;
UPDATE Conversations SET last_message_id = 8 WHERE conversation_id = 3;
UPDATE Conversations SET last_message_id = 7 WHERE conversation_id = 4;
UPDATE Conversations SET last_message_id = 10 WHERE conversation_id = 5;


INSERT INTO Conversation_User_Settings (conversation_id, user_id, role, joined_at, left_at, user_muted, chat_muted, chat_mute_time, favourited, visibility) VALUES
(1, 2, 'Owner', DATE_SUB(NOW(), INTERVAL 30 DAY), NULL, 0, NULL, NULL, 1, 1),
(1, 4, 'Member', DATE_SUB(NOW(), INTERVAL 30 DAY), NULL, 0, NULL, NULL, 0, 1),
(4, 1, 'Owner', DATE_SUB(NOW(), INTERVAL 5 DAY), NULL, 0, NULL, NULL, 1, 1),
(4, 2, 'Admin', DATE_SUB(NOW(), INTERVAL 5 DAY), NULL, 0, NULL, NULL, 0, 1),
(4, 6, 'Member', DATE_SUB(NOW(), INTERVAL 5 DAY), NULL, 0, '8 hours', DATE_ADD(NOW(), INTERVAL 4 HOUR), 0, 1);


INSERT INTO Message_Interactions (message_id, user_id, read_at, emoji, reacted_at, bookmarked_at, pinned_at) VALUES
(1, 4, DATE_SUB(NOW(), INTERVAL 9 DAY), '👍', DATE_SUB(NOW(), INTERVAL 9 DAY), NULL, NULL),
(5, 2, DATE_SUB(NOW(), INTERVAL 2 DAY), '👀', DATE_SUB(NOW(), INTERVAL 2 DAY), NULL, NULL),
(7, 2, DATE_SUB(NOW(), INTERVAL 1 DAY), '✅', DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY));


INSERT INTO Attachments (attachment_id, uploader_id, file_url, file_name, doc_type, file_size, created_at) VALUES
(1, 2, '/files/api_v2_spec.pdf', 'api_v2_spec.pdf', 'tbc', 2048000, DATE_SUB(NOW(), INTERVAL 25 DAY)),
(2, 6, '/files/db_backup_logs.txt', 'db_backup_logs.txt', 'tbc', 51200, DATE_SUB(NOW(), INTERVAL 2 DAY));

INSERT INTO Message_Attachments (message_id, attachment_id) VALUES
(1, 1), (6, 2);


INSERT INTO Mentions (message_id, mentioned_user_id) VALUES
(3, 5), -- Kyle mentions Kate
(5, 2), -- Sarah mentions Marcus
(6, 6); -- Marcus mentions Miles


INSERT INTO Notifications (notification_id, sender_id, reciever_id, priority, is_read, title, message) VALUES
(1, 1, 2, 'high', 0, 'Project At Risk', 'Legacy DB Sunset has been flagged as At Risk.'),
(2, 2, 6, 'urgent', 0, 'Overdue Task', 'Task "Backup DB Table A" is 10 days overdue.'),
(3, 3, 5, 'high', 0, 'Overdue Task', 'Task "Migrate User Settings Page" is 5 days overdue.'),
(4, 2, 4, 'low', 1, 'Task Validated', 'Your task "Setup Node Express boilerplate" was completed.'),
(5, 4, 5, 'medium', 0, 'New Mention', 'Kyle Reese mentioned you in "Frontend Revamp Alpha".');


INSERT INTO Chat_Project_Link (conversation_id, project_id) VALUES
(1, 1), (2, 2), (4, 3);


INSERT INTO Favourites (employee_id, favourited_employee_id) VALUES
(1, 2), (1, 3), (4, 2), (5, 3);

SET FOREIGN_KEY_CHECKS = 1;