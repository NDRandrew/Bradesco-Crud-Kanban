<?php
// controllers/AuthController.php
class AuthController extends BaseController {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }
    
    public function login() {
        // Limpar qualquer saída existente
        if (ob_get_level()) {
            ob_clean();
        }
        
        if (Session::isLoggedIn()) {
            $this->redirect('/dashboard');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $error = 'Por favor, preencha todos os campos';
                $this->render('auth/login', compact('error'));
                return;
            }
            
            $user = $this->userModel->authenticate($email, $password);
            
            if ($user) {
                Session::set('user_id', $user['id']);
                Session::set('user_name', $user['name']);
                Session::set('user_role', $user['role']);
                $this->redirect('/dashboard');
                return;
            } else {
                $error = 'E-mail ou senha inválidos';
                $this->render('auth/login', compact('error'));
                return;
            }
        } else {
            $this->render('auth/login');
        }
    }
    
    public function logout() {
        Session::destroy();
        $this->redirect('/auth/login');
    }
}
?>