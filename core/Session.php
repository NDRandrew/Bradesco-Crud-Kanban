<?php
// core/Session.php
class Session {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        self::start();
        return $_SESSION[$key] ?? $default;
    }
    
    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }
    
    public static function destroy() {
        self::start();
        session_destroy();
        session_write_close();
        
        // Clear session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
    }
    
    public static function isLoggedIn() {
        return self::has('user_id') && !empty(self::get('user_id'));
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            // Clean any output before redirect
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            // Get current script directory for base path
            $scriptName = $_SERVER['SCRIPT_NAME'];
            $basePath = str_replace('\\', '/', dirname($scriptName));
            if ($basePath === '/') {
                $basePath = '';
            } else {
                $basePath = rtrim($basePath, '/');
            }
            
            if (!headers_sent()) {
                header('Location: ' . $basePath . '/auth/login');
            } else {
                echo "<script>window.location.href = '" . $basePath . "/auth/login';</script>";
            }
            exit;
        }
    }
}
?>