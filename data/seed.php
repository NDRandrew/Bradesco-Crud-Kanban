<?php
require_once '../core/JsonDatabase.php';

$db = new JsonDatabase();

// Create sample users
$users = [
    [
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => password_hash('password', PASSWORD_DEFAULT),
        'role' => 'admin'
    ],
    [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => password_hash('password123', PASSWORD_DEFAULT),
        'role' => 'user'
    ],
    [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'password' => password_hash('password123', PASSWORD_DEFAULT),
        'role' => 'user'
    ]
];

// Create sample tasks
$tasks = [
    [
        'title' => 'Setup Development Environment',
        'description' => 'Install PHP, configure web server, and setup project structure',
        'status' => 'done',
        'position' => 0,
        'user_id' => 1
    ],
    [
        'title' => 'Create User Authentication',
        'description' => 'Implement login system with session management',
        'status' => 'done',
        'position' => 1,
        'user_id' => 1
    ],
    [
        'title' => 'Build Dashboard UI',
        'description' => 'Design responsive dashboard with Bootstrap components',
        'status' => 'in_progress',
        'position' => 0,
        'user_id' => 1
    ],
    [
        'title' => 'Implement Drag & Drop',
        'description' => 'Add Kanban board with SortableJS for task management',
        'status' => 'todo',
        'position' => 0,
        'user_id' => 1
    ],
    [
        'title' => 'Add User Management',
        'description' => 'CRUD operations for user administration panel',
        'status' => 'todo',
        'position' => 1,
        'user_id' => 1
    ],
    [
        'title' => 'Security Hardening',
        'description' => 'Add CSRF protection and comprehensive input validation',
        'status' => 'todo',
        'position' => 2,
        'user_id' => 1
    ]
];

// Clear existing data and insert new data
$db->write('users', []);
$db->write('tasks', []);

// Insert users
foreach ($users as $user) {
    $user['id'] = count($db->read('users')) + 1;
    $user['created_at'] = date('Y-m-d H:i:s');
    $allUsers = $db->read('users');
    $allUsers[] = $user;
    $db->write('users', $allUsers);
}

// Insert tasks
foreach ($tasks as $task) {
    $task['id'] = count($db->read('tasks')) + 1;
    $task['created_at'] = date('Y-m-d H:i:s');
    $allTasks = $db->read('tasks');
    $allTasks[] = $task;
    $db->write('tasks', $allTasks);
}

echo "Sample data created successfully!\n";
echo "Users created: " . count($users) . "\n";
echo "Tasks created: " . count($tasks) . "\n";
echo "\nDefault login credentials:\n";
echo "Email: admin@example.com\n";
echo "Password: password\n";
?>