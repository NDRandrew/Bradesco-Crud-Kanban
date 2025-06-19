<?php
// models/Task.php
class Task {
    private $db;
    private $table = 'tasks';
    
    public function __construct() {
        $this->db = new JsonDatabase();
    }
    
    public function getAll() {
        $tasks = $this->db->read($this->table);
        
        // Sort by position
        usort($tasks, function($a, $b) {
            return ($a['position'] ?? 0) - ($b['position'] ?? 0);
        });
        
        return $tasks;
    }
    
    public function create($taskData) {
        $taskData['status'] = $taskData['status'] ?? 'todo';
        $taskData['position'] = $taskData['position'] ?? 0;
        
        return $this->db->insert($this->table, $taskData);
    }
    
    public function update($id, $taskData) {
        return $this->db->update($this->table, $id, $taskData);
    }
    
    public function delete($id) {
        return $this->db->delete($this->table, $id);
    }
    
    public function updateStatus($id, $status, $position) {
        $task = $this->db->findById($this->table, $id);
        if (!$task) {
            return false;
        }
        
        $task['status'] = $status;
        $task['position'] = $position;
        
        return $this->db->update($this->table, $id, $task);
    }
    
    public function getByStatus($status) {
        return $this->db->findAll($this->table, 'status', $status);
    }
    
    public function getByUserId($userId) {
        return $this->db->findAll($this->table, 'user_id', $userId);
    }
}
?>