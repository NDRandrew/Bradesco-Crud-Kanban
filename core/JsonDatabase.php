<?php
// core/JsonDatabase.php
class JsonDatabase {
    private $dataPath;
    
    public function __construct($dataPath = 'data/') {
        $this->dataPath = $dataPath;
        $this->ensureDataDirectory();
    }
    
    private function ensureDataDirectory() {
        if (!is_dir($this->dataPath)) {
            mkdir($this->dataPath, 0755, true);
        }
    }
    
    private function getFilePath($table) {
        return $this->dataPath . $table . '.json';
    }
    
    public function read($table) {
        $filePath = $this->getFilePath($table);
        
        if (!file_exists($filePath)) {
            return [];
        }
        
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
        
        // Return empty array if JSON is invalid
        return $data ?: [];
    }
    
    public function write($table, $data) {
        $filePath = $this->getFilePath($table);
        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return file_put_contents($filePath, $jsonData) !== false;
    }
    
    public function insert($table, $record) {
        $data = $this->read($table);
        
        // Auto-generate ID
        $maxId = 0;
        foreach ($data as $item) {
            if (isset($item['id']) && $item['id'] > $maxId) {
                $maxId = $item['id'];
            }
        }
        
        $record['id'] = $maxId + 1;
        $record['created_at'] = date('Y-m-d H:i:s');
        
        $data[] = $record;
        
        if ($this->write($table, $data)) {
            return $record['id'];
        }
        
        return false;
    }
    
    public function update($table, $id, $record) {
        $data = $this->read($table);
        
        foreach ($data as $index => $item) {
            if ($item['id'] == $id) {
                $record['id'] = $id;
                $record['created_at'] = $item['created_at'] ?? date('Y-m-d H:i:s');
                $record['updated_at'] = date('Y-m-d H:i:s');
                $data[$index] = $record;
                return $this->write($table, $data);
            }
        }
        
        return false;
    }
    
    public function delete($table, $id) {
        $data = $this->read($table);
        
        foreach ($data as $index => $item) {
            if ($item['id'] == $id) {
                unset($data[$index]);
                $data = array_values($data); // Re-index array
                return $this->write($table, $data);
            }
        }
        
        return false;
    }
    
    public function find($table, $field, $value) {
        $data = $this->read($table);
        
        foreach ($data as $item) {
            if (isset($item[$field]) && $item[$field] === $value) {
                return $item;
            }
        }
        
        return null;
    }
    
    public function findById($table, $id) {
        return $this->find($table, 'id', (int)$id);
    }
    
    public function findAll($table, $field = null, $value = null) {
        $data = $this->read($table);
        
        if ($field === null || $value === null) {
            return $data;
        }
        
        return array_filter($data, function($item) use ($field, $value) {
            return isset($item[$field]) && $item[$field] === $value;
        });
    }
}
?>