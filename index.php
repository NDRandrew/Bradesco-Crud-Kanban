<?php
// index.php - Debug version
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output buffering to prevent header issues
ob_start();

session_start();

// Include core files
require_once 'core/JsonDatabase.php';
require_once 'core/Session.php';
require_once 'core/Router.php';

// Include models
require_once 'models/User.php';
require_once 'models/Task.php';

// Include controllers
require_once 'controllers/BaseController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/TaskController.php';

try {
    // Initialize the application
    $router = new Router();
    $router->handleRequest();
} catch (Exception $e) {
    // Clean output buffer before showing error
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    echo "<h1>Application Error</h1>";
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>File: " . $e->getFile() . " (Line: " . $e->getLine() . ")</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>