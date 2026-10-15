
CREATE TABLE Employees (
    employee_id INT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(191),
    role_type SET('employee', 'teamLeader', 'manager'),
    job_title VARCHAR(200),
    profile_picture VARBINARY(8000),
    manager_id INT,
    status SET('online', 'offline', 'busy'),
    last_login DATETIME,
    created_at DATETIME,
    password VARCHAR(255),
    visibility TINYINT(1),
    FOREIGN KEY (manager_id) REFERENCES Employees(employee_id)
);

CREATE TABLE Categories (
    category_id INT PRIMARY KEY,
    categories SET('frontend dev', 'backend dev', 'sales', 'management', 'python', 'web dev', 'SQL')
);

CREATE TABLE Conversations (
    conversation_id INT PRIMARY KEY,
    type SET('DM', 'GC'),
    title VARCHAR(100),
    creator_id INT,
    created_at DATETIME,
    last_message_id INT,
    visibility TINYINT(1),
    FOREIGN KEY (creator_id) REFERENCES Employees(employee_id)
);

CREATE TABLE Projects (
    project_id INT PRIMARY KEY,
    name VARCHAR(100),
    status SET('On Time', 'Behind Schedule', 'Ahead of Schedule', 'At Risk'),
    start_date DATETIME,
    due_date DATETIME,
    summary VARCHAR(300),
    milestone VARCHAR(100),
    risk_level SET('Low', 'Medium', 'High', 'Urgent'),
    risk_desc VARCHAR(100),
    teamleader_id INT,
    visibility TINYINT(1),
    created_by INT,
    conversation_id INT,
    FOREIGN KEY (teamleader_id) REFERENCES Employees(employee_id),
    FOREIGN KEY (conversation_id) REFERENCES Conversations(conversation_id)
);

CREATE TABLE Category_Assignment (
    assignment_id INT PRIMARY KEY,
    category_id INT,
    project_id INT,
    employee_id INT,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id),
    FOREIGN KEY (project_id) REFERENCES Projects(project_id),
    FOREIGN KEY (employee_id) REFERENCES Employees(employee_id)
);

CREATE TABLE Notifications (
    notification_id INT PRIMARY KEY,
    sender_id INT,
    reciever_id INT,
    priority SET('low', 'medium', 'high', 'urgent'),
    is_read TINYINT(1),
    title VARCHAR(250),
    message VARCHAR(200),
    FOREIGN KEY (sender_id) REFERENCES Employees(employee_id),
    FOREIGN KEY (reciever_id) REFERENCES Employees(employee_id)
);

CREATE TABLE Project_Assignment (
    project_id INT,
    employee_id INT,
    PRIMARY KEY (project_id, employee_id),
    FOREIGN KEY (project_id) REFERENCES Projects(project_id),
    FOREIGN KEY (employee_id) REFERENCES Employees(employee_id)
);

CREATE TABLE Tasks (
    task_id INT PRIMARY KEY,
    project_id INT,
    assigner_id INT,
    assignee_id INT,
    title VARCHAR(50),
    description VARCHAR(200),
    status SET('Not Started', 'In Progress', 'Awaiting Validation', 'Completed'),
    created_date DATETIME,
    due_date DATETIME,
    priority SET('High', 'Medium', 'Low'),
    estimated_effort SET('XS', 'S', 'M', 'L', 'XL'),
    task_type SET('project', 'private'),
    started_date DATETIME,
    submitted_date DATETIME,
    completed_date DATETIME,
    completion_wait_time TIME,
    completed_by_id INT,
    visibility TINYINT(1),
    FOREIGN KEY (project_id) REFERENCES Projects(project_id),
    FOREIGN KEY (assigner_id) REFERENCES Employees(employee_id),
    FOREIGN KEY (assignee_id) REFERENCES Employees(employee_id),
    FOREIGN KEY (completed_by_id) REFERENCES Employees(employee_id)
);

CREATE TABLE Task_dependency (
    task_id INT,
    dependency_id INT,
    PRIMARY KEY (task_id, dependency_id),
    FOREIGN KEY (task_id) REFERENCES Tasks(task_id),
    FOREIGN KEY (dependency_id) REFERENCES Tasks(task_id)
);

CREATE TABLE Conversation_User_Settings (
    conversation_id INT,
    user_id INT,
    role SET('Owner', 'Admin', 'Member'),
    joined_at DATETIME,
    left_at DATETIME,
    user_muted TINYINT(1),
    chat_muted SET('1 hour', '4 hours', '8 hours', '24 hours', 'Always'),
    chat_mute_time DATETIME,
    favourited TINYINT(1),
    visibility TINYINT(1),
    PRIMARY KEY (conversation_id, user_id),
    FOREIGN KEY (conversation_id) REFERENCES Conversations(conversation_id),
    FOREIGN KEY (user_id) REFERENCES Employees(employee_id)
);

CREATE TABLE Messages (
    message_id INT PRIMARY KEY,
    conversation_id INT,
    sender_id INT,
    parent_messgae_id INT,
    body VARCHAR(500),
    created_at DATETIME,
    visibility TINYINT(1),
    FOREIGN KEY (conversation_id) REFERENCES Conversations(conversation_id),
    FOREIGN KEY (sender_id) REFERENCES Employees(employee_id),
    FOREIGN KEY (parent_messgae_id) REFERENCES Messages(message_id)
);

ALTER TABLE Conversations 
ADD FOREIGN KEY (last_message_id) REFERENCES Messages(message_id);

CREATE TABLE Message_Interactions (
    message_id INT,
    user_id INT,
    read_at DATETIME,
    emoji VARCHAR(100),
    reacted_at DATETIME,
    bookmarked_at DATETIME,
    pinned_at DATETIME,
    PRIMARY KEY (message_id, user_id),
    FOREIGN KEY (message_id) REFERENCES Messages(message_id),
    FOREIGN KEY (user_id) REFERENCES Employees(employee_id)
);

CREATE TABLE Attachments (
    attachment_id INT PRIMARY KEY,
    uploader_id INT,
    file_url VARCHAR(300),
    file_name VARCHAR(100),
    doc_type SET('tbc'),
    file_size BIGINT,
    created_at DATETIME,
    FOREIGN KEY (uploader_id) REFERENCES Employees(employee_id)
);

CREATE TABLE Message_Attachments (
    message_id INT,
    attachment_id INT,
    PRIMARY KEY (message_id, attachment_id),
    FOREIGN KEY (message_id) REFERENCES Messages(message_id),
    FOREIGN KEY (attachment_id) REFERENCES Attachments(attachment_id)
);

CREATE TABLE Mentions (
    message_id INT,
    mentioned_user_id INT,
    PRIMARY KEY (message_id, mentioned_user_id),
    FOREIGN KEY (message_id) REFERENCES Messages(message_id),
    FOREIGN KEY (mentioned_user_id) REFERENCES Employees(employee_id)
);

CREATE TABLE Chat_Project_Link (
    conversation_id INT,
    project_id INT,
    PRIMARY KEY (conversation_id, project_id),
    FOREIGN KEY (conversation_id) REFERENCES Conversations(conversation_id),
    FOREIGN KEY (project_id) REFERENCES Projects(project_id)
);

CREATE TABLE Favourites (
    employee_id INT,
    favourited_employee_id INT,
    PRIMARY KEY (employee_id, favourited_employee_id),
    FOREIGN KEY (employee_id) REFERENCES Employees(employee_id),
    FOREIGN KEY (favourited_employee_id) REFERENCES Employees(employee_id)
);