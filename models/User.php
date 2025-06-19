<?php
// models/User.php
class User {
    private $db;
    private $table = 'users';
    
    public function __construct() {
        $this->db = new JsonDatabase();
    }
    
    public function findByEmail($email) {
        return $this->db->find($this->table, 'email', $email);
    }
    
    public function findById($id) {
        return $this->db->findById($this->table, $id);
    }
    
    public function create($userData) {
        // Hash password before saving
        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        $userData['role'] = $userData['role'] ?? 'user';
        
        return $this->db->insert($this->table, $userData);
    }
    
    public function update($id, $userData) {
        $existingUser = $this->findById($id);
        if (!$existingUser) {
            return false;
        }
        
        // Keep existing password if new one is empty
        if (empty($userData['password'])) {
            $userData['password'] = $existingUser['password'];
        } else {
            $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        }
        
        return $this->db->update($this->table, $id, $userData);
    }
    
    public function delete($id) {
        return $this->db->delete($this->table, $id);
    }
    
    public function getAll() {
        $users = $this->db->read($this->table);
        
        // Remove password from results for security
        return array_map(function($user) {
            unset($user['password']);
            return $user;
        }, $users);
    }
    
    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            // Remove password from returned user data
            unset($user['password']);
            return $user;
        }
        return false;
    }
}
?>