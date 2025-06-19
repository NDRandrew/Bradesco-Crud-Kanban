<?php
class DatabaseConfig {
    const HOST = 'localhost';
    const DB_NAME = 'mvc_app';
    const USERNAME = 'root';
    const PASSWORD = '123123';
    
    public static function getConnection() {
        try {
            $pdo = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DB_NAME, self::USERNAME, self::PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
?>