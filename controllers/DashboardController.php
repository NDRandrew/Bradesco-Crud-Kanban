<?php
class DashboardController extends BaseController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function index() {
        Session::requireLogin();
        $user = $this->userModel->findById(Session::get('user_id'));
        $this->render('dashboard/index', compact('user'));
    }
    
    public function users() {
        Session::requireLogin();
        
        if (Session::get('user_role') !== 'admin') {
            $this->redirect('/dashboard');
        }
        
        $users = $this->userModel->getAll();
        $this->render('dashboard/users', compact('users'));
    }
    
    public function createUser() {
        Session::requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => $_POST['role']
            ];
            
            if ($this->userModel->create($userData)) {
                $this->redirect('/dashboard/users');
            }
        }
    }
    
    public function editUser() {
        Session::requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $userData = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => $_POST['role']
            ];
            
            if ($this->userModel->update($id, $userData)) {
                $this->redirect('/dashboard/users');
            }
        }
    }
    
    public function deleteUser() {
        Session::requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $this->userModel->delete($id);
            $this->redirect('/dashboard/users');
        }
    }
}
?>