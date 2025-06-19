<?php
// controllers/BaseController.php
abstract class BaseController {
    protected $basePath;
    
    public function __construct() {
        $this->setBasePath();
    }
    
    private function setBasePath() {
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $this->basePath = str_replace('\\', '/', dirname($scriptName));
        if ($this->basePath === '/') {
            $this->basePath = '';
        } else {
            $this->basePath = rtrim($this->basePath, '/');
        }
    }
    
    protected function render($view, $data = []) {
        // Ensure no output has been sent
        if (ob_get_level()) {
            ob_clean();
        }
        
        extract($data);
        $basePath = $this->basePath; // Make basePath available in views
        
        ob_start();
        include "views/{$view}.php";
        $content = ob_get_clean();
        include 'views/layout/header.php';
        echo $content;
        include 'views/layout/footer.php';
    }
    
    protected function redirect($url) {
        // Clean any output buffers
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Ensure URL is properly formatted
        if (empty($url)) {
            $url = '/';
        }
        
        // Add base path to relative URLs only if URL doesn't already contain it
        if ($url[0] === '/' && $this->basePath && strpos($url, $this->basePath) !== 0) {
            $url = $this->basePath . $url;
        }
        
        // Ensure headers haven't been sent
        if (!headers_sent()) {
            header("Location: {$url}");
            exit;
        } else {
            // Fallback if headers already sent
            echo "<script>window.location.href = '{$url}';</script>";
            echo "<noscript><meta http-equiv='refresh' content='0;url={$url}'></noscript>";
            exit;
        }
    }
    
    protected function json($data) {
        // Clean any output buffers
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        if (!headers_sent()) {
            header('Content-Type: application/json');
        }
        echo json_encode($data);
        exit;
    }
    
    protected function url($path = '') {
        return $this->basePath . '/' . ltrim($path, '/');
    }
}
?>