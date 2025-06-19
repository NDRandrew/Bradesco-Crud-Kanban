<?php
class Router {
    private $routes = [];
    private $basePath = '';
    
    public function __construct() {
        $this->setBasePath();
        $this->defineRoutes();
    }
    
    private function setBasePath() {
        // Auto-detect base path from current directory
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $this->basePath = str_replace('\\', '/', dirname($scriptName));
        if ($this->basePath !== '/') {
            $this->basePath = rtrim($this->basePath, '/');
        }
    }
    
    private function defineRoutes() {
        $this->routes = [
            '' => ['controller' => 'AuthController', 'method' => 'login'],
            'auth/login' => ['controller' => 'AuthController', 'method' => 'login'],
            'auth/logout' => ['controller' => 'AuthController', 'method' => 'logout'],
            'dashboard' => ['controller' => 'DashboardController', 'method' => 'index'],
            'dashboard/users' => ['controller' => 'DashboardController', 'method' => 'users'],
            'dashboard/user/create' => ['controller' => 'DashboardController', 'method' => 'createUser'],
            'dashboard/user/edit' => ['controller' => 'DashboardController', 'method' => 'editUser'],
            'dashboard/user/delete' => ['controller' => 'DashboardController', 'method' => 'deleteUser'],
            'tasks/kanban' => ['controller' => 'TaskController', 'method' => 'kanban'],
            'tasks/update' => ['controller' => 'TaskController', 'method' => 'updateTask'],
            'tasks/create' => ['controller' => 'TaskController', 'method' => 'createTask'],
        ];
    }
    
    public function handleRequest() {
        $requestUri = $_SERVER['REQUEST_URI'];
        $path = parse_url($requestUri, PHP_URL_PATH);
        
        // Remove base path from the request path
        if ($this->basePath !== '/' && strpos($path, $this->basePath) === 0) {
            $path = substr($path, strlen($this->basePath));
        }
        
        $path = trim($path, '/');
        
        // Debug: Uncomment this line to see what path is being processed
        // echo "Processing path: '$path'<br>";
        
        if (isset($this->routes[$path])) {
            $route = $this->routes[$path];
            $controller = new $route['controller']();
            $method = $route['method'];
            $controller->$method();
        } else {
            $this->notFound();
        }
    }
    
    private function notFound() {
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        echo "<p>The requested page could not be found.</p>";
        echo "<p><a href='{$this->basePath}'>Go back to home</a></p>";
    }
    
    public function getBasePath() {
        return $this->basePath;
    }
}
?>