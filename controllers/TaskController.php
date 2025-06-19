<?php
class TaskController extends BaseController {
    private $taskModel;
    
    public function __construct() {
        $this->taskModel = new Task();
    }
    
    public function kanban() {
        Session::requireLogin();
        $tasks = $this->taskModel->getAll();
        $this->render('tasks/kanban', compact('tasks'));
    }
    
    public function updateTask() {
        Session::requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $success = $this->taskModel->updateStatus(
                $data['id'],
                $data['status'],
                $data['position']
            );
            
            $this->json(['success' => $success]);
        }
    }
    
    public function createTask() {
        Session::requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskData = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'status' => 'todo',
                'position' => 0,
                'user_id' => Session::get('user_id')
            ];
            
            if ($this->taskModel->create($taskData)) {
                $this->redirect('/tasks/kanban');
            }
        }
    }
}
?>